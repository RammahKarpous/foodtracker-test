<div class="w-full">
    <div class="flex items-center justify-center gap-4 mb-6">
        <button 
            wire:click="previousDay" 
            class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
            title="Vorige dag"
        >
            &#8592;
        </button>
        <span class="text-lg text-gray-400 font-semibold">{{ $this->formatDate($selectedDate) }}</span>
        <button 
            wire:click="nextDay" 
            class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
            title="Volgende dag"
        >
            &#8594;
        </button>
    </div>
    
    
    
    <h2 class="text-gray-400 text-xl mb-4">Dagelijks Overzicht - Tabel</h2>
    <div class="w-full overflow-x-auto mb-6">
        @php
            $metrics = [
                ['key' => 'kcal', 'label' => 'Kcal', 'unit' => 'kcal'],
                ['key' => 'vet', 'label' => 'Vet', 'unit' => 'g'],
                ['key' => 'verzadigd', 'label' => 'Verzadigd vet', 'unit' => 'g'],
                ['key' => 'koolhydraten', 'label' => 'Koolhydraten', 'unit' => 'g'],
                ['key' => 'suiker', 'label' => 'Suiker', 'unit' => 'g'],
                ['key' => 'eiwit', 'label' => 'Eiwit', 'unit' => 'g'],
            ];
        @endphp
        <table class="w-full border-collapse border-spacing-0 bg-transparent">
            <thead>
                <tr>
                    <th class="px-2 text-left py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Metric</th>
                    <th class="px-2 text-left py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Gegeten</th>
                    <th class="px-2 text-left py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Doel</th>
                    <th class="px-2 text-left py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Voortgang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($metrics as $m)
                    @php
                        $current = (float)($totals[$m['key']] ?? 0);
                        $goal = (float)($limits[$m['key']] ?? 0);
                        $percentage = $goal > 0 ? ($current / $goal * 100) : 0;
                        $progressClass = $percentage > 110 ? 'danger' : ($percentage > 100 ? 'warning' : '');
                        $progressColor = $progressClass === 'danger' ? '#e74c3c' : ($progressClass === 'warning' ? '#f39c12' : '#3b82f6');
                    @endphp
                    <tr class="border-b border-white border-opacity-8">
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ $m['label'] }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ number_format($current, 1) }}{{ $m['unit'] }}</td>
                        <td class="px-2 py-2 text-gray-300 text-xs">{{ number_format($goal, 1) }}{{ $m['unit'] }}</td>
                        <td class="px-2 py-2 text-xs">
                            <div class="text-gray-300">{{ number_format($percentage, 1) }}%</div>
                            <div class="progress-bar w-full h-2 bg-black bg-opacity-30 rounded-lg overflow-hidden mt-1.5">
                                <div class="progress-fill h-full rounded-lg transition-all duration-300" style="background: {{ $progressColor }}; width: {{ min($percentage, 100) }}%;"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
