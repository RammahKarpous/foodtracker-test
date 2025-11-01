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
        
        $data = [
            'user_id' => Auth::id(),
            'naam' => $this->naam,
            'kcal' => floatval(str_replace(',', '.', $this->kcal)),
            'vet' => floatval(str_replace(',', '.', $this->vet)),
            'verzadigd' => floatval(str_replace(',', '.', $this->verzadigd)),
            'koolhydraten' => floatval(str_replace(',', '.', $this->koolhydraten)),
            'suiker' => floatval(str_replace(',', '.', $this->suiker)),
            'eiwit' => floatval(str_replace(',', '.', $this->eiwit)),
        ];
        
        if ($this->editingId) {
            Product::where('id', $this->editingId)->update($data);
        } else {
            Product::create($data);
        }
        
        $this->reset('naam', 'kcal', 'vet', 'verzadigd', 'koolhydraten', 'suiker', 'eiwit', 'editingId');
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->first();
        if ($product) {
            $this->editingId = $id;
            $this->naam = $product->naam;
            $this->kcal = $product->kcal;
            $this->vet = $product->vet;
            $this->verzadigd = $product->verzadigd;
            $this->koolhydraten = $product->koolhydraten;
            $this->suiker = $product->suiker;
            $this->eiwit = $product->eiwit;
        }
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
