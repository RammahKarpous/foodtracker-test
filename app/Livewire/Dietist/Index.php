<?php

namespace App\Livewire\Dietist;

use Livewire\Component;
use App\Models\DiaryEntry;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Index extends Component
{
    public $selectedDate;
    public $overviewDate;
    public $currentWeekMonday;
    
    // Goals - daily limits
    const GOALS = [
        'groente' => ['name' => 'Groente', 'max' => 250, 'color' => '#27ae60', 'unit' => 'g'],
        'fruit' => ['name' => 'Fruit', 'max' => 300, 'color' => '#e74c3c', 'unit' => 'g'],
        'koolhydraten' => ['name' => 'Koolhydraten', 'max' => 495, 'color' => '#f39c12', 'unit' => 'g'],
        'vlees' => ['name' => 'Vlees', 'max' => 100, 'color' => '#e67e22', 'unit' => 'g'],
        'noten' => ['name' => 'Ongezouten noten', 'max' => 25, 'color' => '#8e44ad', 'unit' => 'g'],
        'zuivel' => ['name' => 'Zuivelproducten', 'max' => 450, 'color' => '#3498db', 'unit' => 'g'],
        'kaas' => ['name' => 'Kaas', 'max' => 40, 'color' => '#f1c40f', 'unit' => 'g'],
        'bereidingsvet' => ['name' => 'Bereidingsvet', 'max' => 15, 'color' => '#95a5a6', 'unit' => 'g'],
        'margarine' => ['name' => 'Margarine', 'max' => 15, 'color' => '#7f8c8d', 'unit' => 'g'],
        'onbekend' => ['name' => 'Onbekend', 'max' => 100, 'color' => '#9e9e9e', 'unit' => 'g'],
        'vocht' => ['name' => 'Vocht', 'max' => 2000, 'color' => '#00bcd4', 'unit' => 'ml'],
    ];
    
    const RED_MEAT_WEEKLY_LIMIT = 300; // grams per week

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->overviewDate = now()->format('Y-m-d');
        $this->currentWeekMonday = $this->getMondayOfWeek(now())->format('Y-m-d');
    }

    public function changeDay($offset)
    {
        $date = Carbon::parse($this->selectedDate)->addDays($offset);
        $this->selectedDate = $date->format('Y-m-d');
    }

    public function changeOverviewDay($offset)
    {
        $date = Carbon::parse($this->overviewDate)->addDays($offset);
        $this->overviewDate = $date->format('Y-m-d');
    }

    public function changeWeek($offsetWeeks)
    {
        $this->currentWeekMonday = Carbon::parse($this->currentWeekMonday)
            ->addWeeks($offsetWeeks)
            ->format('Y-m-d');
    }

    public function getMondayOfWeek($date)
    {
        $d = Carbon::parse($date);
        $day = $d->dayOfWeek; // 0 = Sunday, 1 = Monday
        $diff = $day === 0 ? -6 : 1 - $day; // If Sunday, go back 6 days
        return $d->copy()->addDays($diff)->startOfDay();
    }

    public string $activeTab = 'overzicht';

    public function switchTab(string $tabName): void
    {
        $this->activeTab = $tabName;
    }

    public function getDailyDataProperty()
    {
        $entries = DiaryEntry::where('user_id', Auth::id())
            ->whereDate('datum', $this->selectedDate)
            ->whereNotNull('category')
            ->get();

        $data = [];
        foreach (array_keys(self::GOALS) as $key) {
            $data[$key] = $entries->where('category', $key)->sum('gram');
            $data[$key . '_history'] = $entries->where('category', $key)
                ->map(function ($entry) {
                    return [
                        'id' => $entry->id,
                        'name' => $entry->product_naam,
                        'grams' => $entry->gram,
                        'isRedMeat' => $entry->is_red_meat ?? false,
                    ];
                })
                ->values()
                ->toArray();
        }
        return $data;
    }

    public function getOverviewDataProperty()
    {
        $entries = DiaryEntry::where('user_id', Auth::id())
            ->whereDate('datum', $this->overviewDate)
            ->whereNotNull('category')
            ->get();

        $data = [];
        foreach (array_keys(self::GOALS) as $key) {
            $data[$key] = $entries->where('category', $key)->sum('gram');
        }
        return $data;
    }

    public function getWeekDataProperty()
    {
        $monday = Carbon::parse($this->currentWeekMonday);
        $weekData = [];
        
        for ($i = 0; $i < 5; $i++) {
            $date = $monday->copy()->addDays($i);
            $entries = DiaryEntry::where('user_id', Auth::id())
                ->whereDate('datum', $date->format('Y-m-d'))
                ->whereNotNull('category')
                ->get();
            
            $dayData = [];
            foreach (array_keys(self::GOALS) as $key) {
                $dayData[$key] = $entries->where('category', $key)->sum('gram');
            }
            $weekData[$date->format('Y-m-d')] = $dayData;
        }
        
        return $weekData;
    }

    public function getWeeklyRedMeatTotalProperty()
    {
        $monday = Carbon::parse($this->currentWeekMonday);
        $total = 0;
        
        for ($i = 0; $i < 5; $i++) {
            $date = $monday->copy()->addDays($i);
            $total += DiaryEntry::where('user_id', Auth::id())
                ->whereDate('datum', $date->format('Y-m-d'))
                ->where('category', 'vlees')
                ->where('is_red_meat', true)
                ->sum('gram');
        }
        
        return $total;
    }

    public function formatDate($date)
    {
        $d = Carbon::parse($date);
        $dagen = ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'];
        $maanden = ['januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'];
        return ucfirst($dagen[$d->dayOfWeek]) . ' ' . $d->day . ' ' . $maanden[$d->month - 1];
    }

    public function formatWeekDisplay()
    {
        $monday = Carbon::parse($this->currentWeekMonday);
        $friday = $monday->copy()->addDays(4);
        return sprintf('%02d/%02d – %02d/%02d', 
            $monday->day, 
            $monday->month, 
            $friday->day, 
            $friday->month
        );
    }

    public function render()
    {
        // Build donut charts for the Overzicht date
        $overviewDonuts = [];
        foreach (self::GOALS as $key => $goal) {
            $current = $this->overviewData[$key] ?? 0;
            $remaining = max(0, $goal['max'] - $current);

            $overviewDonuts[$key] = (new LarapexChart)
                ->setType('donut')
                ->setLabels(['Gegeten', 'Resterend'])
                ->setDataset([(float) $current, (float) $remaining])
                ->setColors(['#4c7fba', '#2c2c2e'])
                ->setHeight(260);
        }

        return view('livewire.dietist.index', compact('overviewDonuts'));
    }
}
