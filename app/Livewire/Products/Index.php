<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public function lookupBarcode($barcode)
    {
        $barcode = preg_replace('/[^0-9]/', '', (string) $barcode);

        if ($barcode === '') {
            $this->dispatch('scan-error', message: 'Ongeldige barcode.');
            return;
        }

        try {
            $response = Http::timeout(10)->get("https://world.openfoodfacts.org/api/v2/product/{$barcode}.json");
        } catch (\Throwable $e) {
            $this->dispatch('scan-error', message: 'Kon geen verbinding maken met Open Food Facts.');
            return;
        }

        if (!$response->successful() || $response->json('status') !== 1) {
            $this->dispatch('scan-error', message: "Geen product gevonden voor barcode {$barcode}.");
            return;
        }

        $product = $response->json('product', []);
        $nutriments = $product['nutriments'] ?? [];

        $kcal = $nutriments['energy-kcal_100g'] ?? null;
        if ($kcal === null && isset($nutriments['energy_100g'])) {
            $kcal = $nutriments['energy_100g'] / 4.184;
        }

        $this->naam = $product['product_name'] ?: $this->naam;
        $this->kcal = $this->formatNutrient($kcal);
        $this->vet = $this->formatNutrient($nutriments['fat_100g'] ?? null);
        $this->verzadigd = $this->formatNutrient($nutriments['saturated-fat_100g'] ?? null);
        $this->koolhydraten = $this->formatNutrient($nutriments['carbohydrates_100g'] ?? null);
        $this->suiker = $this->formatNutrient($nutriments['sugars_100g'] ?? null);
        $this->eiwit = $this->formatNutrient($nutriments['proteins_100g'] ?? null);

        session()->flash('message', 'Productgegevens opgehaald van Open Food Facts. Controleer en sla op.');
    }

    private function formatNutrient($value): string
    {
        return $value !== null ? number_format((float) $value, 2, '.', '') : '0.00';
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
