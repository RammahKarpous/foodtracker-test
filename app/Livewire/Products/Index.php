<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $naam = '';
    public $kcal = '';
    public $vet = '';
    public $verzadigd = '';
    public $koolhydraten = '';
    public $suiker = '';
    public $eiwit = '';
    public $search = '';
    
    // Edit form fields
    public $editNaam = '';
    public $editKcal = '';
    public $editVet = '';
    public $editVerzadigd = '';
    public $editKoolhydraten = '';
    public $editSuiker = '';
    public $editEiwit = '';
    public $editingId = null;

    protected function rules()
    {
        return [
            'naam' => 'required|string',
            'kcal' => 'required|numeric',
            'vet' => 'required|numeric',
            'verzadigd' => 'required|numeric',
            'koolhydraten' => 'required|numeric',
            'suiker' => 'required|numeric',
            'eiwit' => 'required|numeric',
        ];
    }

    public function getProductsProperty()
    {
        if (empty($this->search)) {
            return Product::where('user_id', Auth::id())->orderBy('naam')->get();
        }
        return Product::where('user_id', Auth::id())
            ->where('naam', 'like', '%' . $this->search . '%')
            ->orderBy('naam')
            ->get();
    }

    public function save()
    {
        $this->validate();
        
        Product::create([
            'user_id' => Auth::id(),
            'naam' => $this->naam,
            'kcal' => floatval(str_replace(',', '.', $this->kcal)),
            'vet' => floatval(str_replace(',', '.', $this->vet)),
            'verzadigd' => floatval(str_replace(',', '.', $this->verzadigd)),
            'koolhydraten' => floatval(str_replace(',', '.', $this->koolhydraten)),
            'suiker' => floatval(str_replace(',', '.', $this->suiker)),
            'eiwit' => floatval(str_replace(',', '.', $this->eiwit)),
        ]);
        
        session()->flash('message', 'Product is toegevoegd');
        
        $this->reset('naam', 'kcal', 'vet', 'verzadigd', 'koolhydraten', 'suiker', 'eiwit');
        $this->dispatch('product-added');
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->first();
        if ($product) {
            $this->editingId = $id;
            $this->editNaam = $product->naam;
            $this->editKcal = number_format((float)$product->kcal, 2, '.', '');
            $this->editVet = number_format((float)$product->vet, 2, '.', '');
            $this->editVerzadigd = number_format((float)$product->verzadigd, 2, '.', '');
            $this->editKoolhydraten = number_format((float)$product->koolhydraten, 2, '.', '');
            $this->editSuiker = number_format((float)$product->suiker, 2, '.', '');
            $this->editEiwit = number_format((float)$product->eiwit, 2, '.', '');
        }
    }

    public function update()
    {
        $this->validate([
            'editNaam' => 'required|string',
            'editKcal' => 'required|numeric',
            'editVet' => 'required|numeric',
            'editVerzadigd' => 'required|numeric',
            'editKoolhydraten' => 'required|numeric',
            'editSuiker' => 'required|numeric',
            'editEiwit' => 'required|numeric',
        ]);
        
        Product::where('id', $this->editingId)->update([
            'naam' => $this->editNaam,
            'kcal' => floatval(str_replace(',', '.', $this->editKcal)),
            'vet' => floatval(str_replace(',', '.', $this->editVet)),
            'verzadigd' => floatval(str_replace(',', '.', $this->editVerzadigd)),
            'koolhydraten' => floatval(str_replace(',', '.', $this->editKoolhydraten)),
            'suiker' => floatval(str_replace(',', '.', $this->editSuiker)),
            'eiwit' => floatval(str_replace(',', '.', $this->editEiwit)),
        ]);
        
        session()->flash('message', 'Product is bijgewerkt');
        $this->reset('editNaam', 'editKcal', 'editVet', 'editVerzadigd', 'editKoolhydraten', 'editSuiker', 'editEiwit', 'editingId');
    }

    public function closeModal()
    {
        $this->reset('editNaam', 'editKcal', 'editVet', 'editVerzadigd', 'editKoolhydraten', 'editSuiker', 'editEiwit', 'editingId');
    }

    public function delete($id)
    {
        Product::where('id', $id)->where('user_id', Auth::id())->delete();
    }

    public function render()
    {
        return view('livewire.products.index');
    }
}
