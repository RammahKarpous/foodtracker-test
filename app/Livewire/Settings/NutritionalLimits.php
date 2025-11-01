<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\NutritionalLimit;
use Illuminate\Support\Facades\Auth;

class NutritionalLimits extends Component
{
    public $kcal_limiet = '';
    public $vet_limiet = '';
    public $verzadigd_limiet = '';
    public $koolhydraten_limiet = '';
    public $suiker_limiet = '';
    public $eiwit_limiet = '';

    public function mount()
    {
        $limits = NutritionalLimit::where('user_id', Auth::id())->first();
        if ($limits) {
            $this->kcal_limiet = $limits->kcal_limiet;
            $this->vet_limiet = $limits->vet_limiet;
            $this->verzadigd_limiet = $limits->verzadigd_limiet;
            $this->koolhydraten_limiet = $limits->koolhydraten_limiet;
            $this->suiker_limiet = $limits->suiker_limiet;
            $this->eiwit_limiet = $limits->eiwit_limiet;
        }
    }

    public function save()
    {
        $this->validate([
            'kcal_limiet' => 'required|numeric',
            'vet_limiet' => 'required|numeric',
            'verzadigd_limiet' => 'required|numeric',
            'koolhydraten_limiet' => 'required|numeric',
            'suiker_limiet' => 'required|numeric',
            'eiwit_limiet' => 'required|numeric',
        ]);
        
        $data = [
            'kcal_limiet' => floatval(str_replace(',', '.', $this->kcal_limiet)),
            'vet_limiet' => floatval(str_replace(',', '.', $this->vet_limiet)),
            'verzadigd_limiet' => floatval(str_replace(',', '.', $this->verzadigd_limiet)),
            'koolhydraten_limiet' => floatval(str_replace(',', '.', $this->koolhydraten_limiet)),
            'suiker_limiet' => floatval(str_replace(',', '.', $this->suiker_limiet)),
            'eiwit_limiet' => floatval(str_replace(',', '.', $this->eiwit_limiet)),
        ];
        
        NutritionalLimit::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );
        
        session()->flash('message', 'Nutrition limieten zijn bijgewerkt!');
    }

    public function render()
    {
        return view('livewire.settings.nutritional-limits');
    }
}
