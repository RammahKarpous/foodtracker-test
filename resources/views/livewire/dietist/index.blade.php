<div class="w-full">
    <div class="flex gap-2 sm:gap-3 justify-center mb-6 flex-wrap">
        <button 
            class="dietist-tab-btn px-4 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:bg-opacity-40 {{ $activeTab === 'overzicht' ? 'active bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white' : 'bg-black bg-opacity-30 border border-white border-opacity-10 text-gray-300' }}"
            wire:click="switchTab('overzicht')"
        >Overzicht</button>
        <button 
            class="dietist-tab-btn px-4 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:bg-opacity-40 {{ $activeTab === 'week' ? 'active bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white' : 'bg-black bg-opacity-30 border border-white border-opacity-10 text-gray-300' }}"
            wire:click="switchTab('week')"
        >Weekoverzicht</button>
    </div>
    

        <!-- Overzicht Tab -->
        <div id="dietist-overzicht" class="dietist-tab-content {{ $activeTab === 'overzicht' ? 'block' : 'hidden' }}">
            <div class="flex items-center justify-center gap-4 mb-6">
                <button 
                    wire:click="changeOverviewDay(-1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Vorige dag"
                >
                    &#8592;
                </button>
                <span class="text-lg text-gray-400 font-semibold">{{ $this->formatDate($overviewDate) }}</span>
                <button 
                    wire:click="changeOverviewDay(1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Volgende dag"
                >
                    &#8594;
                </button>
            </div>
            
            <h2 class="text-gray-400 text-xl mb-4">Dagelijks Overzicht - Tabel</h2>
            <div class="w-full overflow-x-auto mb-6">
                <table class="w-full border-collapse border-spacing-0 bg-transparent">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Categorie</th>
                            <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Gegeten</th>
                            <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Doel</th>
                            <th class="px-2 py-2 text-gray-400 font-semibold border-b-2 border-white border-opacity-10 text-xs">Voortgang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                            @php
                                $current = $this->overviewData[$key] ?? 0;
                                $percentage = ($current / $goal['max'] * 100);
                                $progressClass = $percentage > 110 ? 'danger' : ($percentage > 100 ? 'warning' : '');
                                $progressColor = $progressClass === 'danger' ? '#e74c3c' : ($progressClass === 'warning' ? '#f39c12' : '#3b82f6');
                            @endphp
                            <tr class="border-b border-white border-opacity-8">
                                <td class="px-2 py-2 text-gray-300 text-xs">{{ $goal['name'] }}</td>
                                <td class="px-2 py-2 text-gray-300 text-xs">{{ number_format($current, 0) }}{{ $goal['unit'] }}</td>
                                <td class="px-2 py-2 text-gray-300 text-xs">{{ $goal['max'] }}{{ $goal['unit'] }}</td>
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

        <!-- Week Tab -->
        <div id="dietist-week" class="dietist-tab-content {{ $activeTab === 'week' ? 'block' : 'hidden' }}">
            <div class="flex items-center justify-center gap-4 mb-6">
                <button 
                    wire:click="changeWeek(-1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Vorige week"
                >
                    &#8592;
                </button>
                <span class="text-lg text-gray-400 font-semibold" id="dietist-weekDisplay">{{ $this->formatWeekDisplay() }}</span>
                <button 
                    wire:click="changeWeek(1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Volgende week"
                >
                    &#8594;
                </button>
            </div>
            
            <h2 class="text-gray-400 text-xl mb-4">Weekoverzicht (Ma - Vr)</h2>
                @php
                    $redMeatTotal = $this->weeklyRedMeatTotal;
                    $redMeatPercentage = ($redMeatTotal / \App\Livewire\Dietist\Index::RED_MEAT_WEEKLY_LIMIT * 100);
                    $redMeatClass = $redMeatPercentage > 100 ? 'danger' : ($redMeatPercentage > 80 ? 'warning' : '');
                    $redMeatValueColor = $redMeatClass === 'danger' ? '#e74c3c' : ($redMeatClass === 'warning' ? '#f39c12' : '#ffffff');
                    $redMeatProgressColor = $redMeatClass === 'danger' ? '#e74c3c' : ($redMeatClass === 'warning' ? '#f39c12' : '#4c7fba');
                @endphp
            <div class="bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg py-4 px-5 mb-6 text-center">
                <h3 class="text-gray-300 text-base font-medium mb-2.5">Rood Vlees - Weeklimiet</h3>
                <div class="red-meat-stats flex justify-between items-center text-gray-400 text-sm">
                    <span>Gegeten:</span>
                    <span class="red-meat-value font-medium" style="color: {{ $redMeatValueColor }};">{{ number_format($redMeatTotal, 0) }}g / {{ \App\Livewire\Dietist\Index::RED_MEAT_WEEKLY_LIMIT }}g</span>
                </div>
                <div class="red-meat-progress w-full h-2 bg-black bg-opacity-30 rounded-lg overflow-hidden mt-2.5">
                    <div class="red-meat-progress-fill h-full rounded-lg transition-all duration-300" style="background: {{ $redMeatProgressColor }}; width: {{ min($redMeatPercentage, 100) }}%;"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @php
                    $monday = \Carbon\Carbon::parse($currentWeekMonday);
                    $dayNames = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag'];
                @endphp
                @for($i = 0; $i < 5; $i++)
                    @php
                        $date = $monday->copy()->addDays($i);
                        $dateString = $date->format('Y-m-d');
                        $dayData = $this->weekData[$dateString] ?? [];
                    @endphp
                    <div class="day-card bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg p-4 text-center">
                        <h3 class="text-gray-300 text-base mb-2.5 font-medium">{{ $dayNames[$i] }}</h3>
                        <div class="day-date text-gray-400 text-xs mb-2.5">{{ $date->day }}/{{ $date->month }}</div>
                        <div class="day-summary flex flex-col gap-1 text-xs">
                                @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                                    @php
                                        $current = $dayData[$key] ?? 0;
                                        $percentage = ($current / $goal['max'] * 100);
                                    @endphp
                                    <div class="day-summary-item flex justify-between text-gray-400">
                                        <span>{{ $goal['name'] }}:</span>
                                        <span class="day-summary-value text-gray-300">{{ number_format($percentage, 0) }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
            </div>
        </div>
    
    
</div>

<script>
document.addEventListener('livewire:init', function () {
    const runApexScripts = () => {
        document.querySelectorAll('template.apex-script:not([data-executed])').forEach(tpl => {
            let code = tpl.innerHTML || tpl.textContent || '';
            code = code.replace(/<\/?script[^>]*>/gi, '');
            if (code.trim().length) {
                try { new Function(code)(); } catch (e) { console.error(e); }
                tpl.setAttribute('data-executed', '1');
            }
        });
    };
    runApexScripts();
    Livewire.hook('message.processed', runApexScripts);
});
</script>
