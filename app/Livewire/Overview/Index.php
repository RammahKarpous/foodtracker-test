<?php

namespace App\Livewire\Overview;

use Livewire\Component;
use App\Models\DiaryEntry;
use App\Models\NutritionalLimit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Index extends Component
{
    public $selectedDate;

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
    }

    public function getTotalsProperty()
    {
        $entries = DiaryEntry::where('user_id', Auth::id())
            ->whereDate('datum', $this->selectedDate)
            ->get();
        
        return [
            'kcal' => $entries->sum('kcal'),
            'vet' => $entries->sum('vet'),
            'verzadigd' => $entries->sum('verzadigd'),
            'koolhydraten' => $entries->sum('koolhydraten'),
            'suiker' => $entries->sum('suiker'),
            'eiwit' => $entries->sum('eiwit'),
        ];
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

    public function formatDate($date)
    {
        $d = Carbon::parse($date);
        $dagen = ['Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag'];
        $maanden = ['januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'];
        return $dagen[$d->dayOfWeek] . ' ' . $d->day . ' ' . $maanden[$d->month - 1] . ' ' . $d->year;
    }

    public function render()
    {
        $totals = $this->totals;
        $limits = $this->limits;

        return view('livewire.overview.index', compact('totals', 'limits'));
    }
}
