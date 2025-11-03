<?php

namespace App\Livewire\Diary;

use Livewire\Component;
use App\Models\Product;
use App\Models\DiaryEntry;
use App\Models\NutritionalLimit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $selectedDate;
    public $moment = '';
    public $productNaam = '';
    public $gram = '';
    public $editingId = null;

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    protected function rules()
    {
        return [
            'moment' => 'required',
            'productNaam' => 'required',
            'gram' => 'required|numeric',
        ];
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
    }

    public function getProductsProperty()
    {
        return Product::where('user_id', Auth::id())->orderBy('naam')->pluck('naam')->toArray();
    }

    public function getEntriesForDateProperty()
    {
        return DiaryEntry::where('user_id', Auth::id())
            ->whereDate('datum', $this->selectedDate)
            ->orderBy('moment')
            ->get();
    }

    public function getMomentenSummaryProperty()
    {
        $entries = $this->entriesForDate;
        $momenten = ['Voor training', 'Na training', 'Ontbijt', 'Lunch', 'Tussendoor', 'Diner'];
        $summary = [];
        
        foreach ($momenten as $moment) {
            $momentEntries = $entries->where('moment', $moment);
            $summary[$moment] = [
                'kcal' => $momentEntries->sum('kcal'),
                'vet' => $momentEntries->sum('vet'),
                'verzadigd' => $momentEntries->sum('verzadigd'),
                'koolhydraten' => $momentEntries->sum('koolhydraten'),
                'suiker' => $momentEntries->sum('suiker'),
                'eiwit' => $momentEntries->sum('eiwit'),
            ];
        }
        
        // Add total
        $summary['Totaal'] = [
            'kcal' => $entries->sum('kcal'),
            'vet' => $entries->sum('vet'),
            'verzadigd' => $entries->sum('verzadigd'),
            'koolhydraten' => $entries->sum('koolhydraten'),
            'suiker' => $entries->sum('suiker'),
            'eiwit' => $entries->sum('eiwit'),
        ];
        
        return $summary;
    }

    public function getLimitsProperty()
    {
        $limits = NutritionalLimit::where('user_id', Auth::id())->first();
        if (!$limits) {
            return [
                'kcal' => 2000,
                'vet' => 50,
                'verzadigd' => 15,
                'koolhydraten' => 220,
                'suiker' => 30,
                'eiwit' => 130,
            ];
        }
        return [
            'kcal' => $limits->kcal_limiet,
            'vet' => $limits->vet_limiet,
            'verzadigd' => $limits->verzadigd_limiet,
            'koolhydraten' => $limits->koolhydraten_limiet,
            'suiker' => $limits->suiker_limiet,
            'eiwit' => $limits->eiwit_limiet,
        ];
    }

    public function save()
    {
        $this->validate();
        
        $product = Product::where('user_id', Auth::id())
            ->whereRaw('LOWER(naam) = LOWER(?)', [$this->productNaam])
            ->first();
        
        if (!$product) {
            $this->addError('productNaam', 'Product niet gevonden');
            return;
        }
        
        $gram = floatval(str_replace(',', '.', $this->gram));
        $data = [
            'user_id' => Auth::id(),
            'product_naam' => $this->productNaam,
            'moment' => $this->moment,
            'gram' => $gram,
            'kcal' => round($product->kcal * $gram / 100, 1),
            'vet' => round($product->vet * $gram / 100, 1),
            'verzadigd' => round($product->verzadigd * $gram / 100, 1),
            'koolhydraten' => round($product->koolhydraten * $gram / 100, 1),
            'suiker' => round($product->suiker * $gram / 100, 1),
            'eiwit' => round($product->eiwit * $gram / 100, 1),
            'datum' => $this->selectedDate,
        ];
        
        if ($this->editingId) {
            DiaryEntry::where('id', $this->editingId)->update($data);
            session()->flash('message', 'Entry is bijgewerkt');
        } else {
            DiaryEntry::create($data);
            session()->flash('message', 'Toegevoegd aan dagboek');
        }
        
        $this->reset('moment', 'productNaam', 'gram', 'editingId');
    }

    public function edit($id)
    {
        $entry = DiaryEntry::where('id', $id)->where('user_id', Auth::id())->first();
        if ($entry) {
            $this->editingId = $id;
            $this->moment = $entry->moment;
            $this->productNaam = $entry->product_naam;
            $this->gram = number_format((float)$entry->gram, 2, '.', '');
        }
    }

    public function deleteEntry($id)
    {
        DiaryEntry::where('id', $id)->where('user_id', Auth::id())->delete();
    }

    public function formatDate($date)
    {
        $d = Carbon::parse($date);
        $dagen = ['Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag'];
        $maanden = ['januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'];
        return $dagen[$d->dayOfWeek] . ' ' . $d->day . ' ' . $maanden[$d->month - 1] . ' ' . $d->year;
    }

    public function render()
    {
        return view('livewire.diary.index');
    }
}
