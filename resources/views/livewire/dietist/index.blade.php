<div class="w-full">
    <div class="flex gap-2 sm:gap-3 justify-center mb-6 flex-wrap">
        <button class="dietist-tab-btn active bg-gradient-to-r from-[#000000] via-[#0A0E1F] to-[#102459] text-white px-4 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:brightness-110" onclick="switchDietistTab('dagboek')">Dagboek</button>
        <button class="dietist-tab-btn bg-black bg-opacity-30 border border-white border-opacity-10 text-gray-300 px-4 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:bg-opacity-40" onclick="switchDietistTab('overzicht')">Overzicht</button>
        <button class="dietist-tab-btn bg-black bg-opacity-30 border border-white border-opacity-10 text-gray-300 px-4 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:bg-opacity-40" onclick="switchDietistTab('week')">Weekoverzicht</button>
    </div>

        <!-- Dagboek Tab -->
        <div id="dietist-dagboek" class="dietist-tab-content block">
            <div class="flex items-center justify-center gap-4 mb-6">
                <button 
                    wire:click="changeDay(-1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Vorige dag"
                >
                    &#8592;
                </button>
                <span class="text-lg text-gray-400 font-semibold">{{ $this->formatDate($selectedDate) }}</span>
                <button 
                    wire:click="changeDay(1)" 
                    class="bg-transparent border-none text-blue-600 text-3xl cursor-pointer"
                    title="Volgende dag"
                >
                    &#8594;
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
                @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                    @php
                        $current = $this->dailyData[$key] ?? 0;
                        $remaining = max(0, $goal['max'] - $current);
                        $percentage = ($current / $goal['max'] * 100);
                        $color = $percentage <= 100 ? 'green' : ($percentage <= 110 ? 'orange' : 'red');
                    @endphp
                    <div class="category-card bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg p-5 transition-all duration-300 hover:bg-opacity-40">
                        <h3 class="text-base mb-4 text-gray-300 text-center font-medium">{{ $goal['name'] }}</h3>
                        <div class="category-chart w-[140px] h-[140px] mx-auto mb-4">
                            <canvas id="dietist-chart-{{ $key }}"></canvas>
                        </div>
                        <div class="category-info flex flex-col gap-2 text-sm">
                            <div class="info-row flex justify-between">
                                <span class="info-label text-gray-400 font-normal">Gegeten:</span>
                                <span class="info-value font-medium text-gray-300">{{ number_format($current, 0) }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-gray-400 font-normal">Maximaal:</span>
                                <span class="info-value font-medium text-gray-300">{{ $goal['max'] }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-gray-400 font-normal">Resterend:</span>
                                <span class="info-value font-medium text-gray-300">{{ number_format($remaining, 0) }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-gray-400 font-normal">Percentage:</span>
                                <span class="info-value font-medium text-gray-300">{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </div>
                        @if($percentage > 110)
                            <div class="warning red mt-3 px-3 py-2 rounded-md text-xs font-normal bg-red-600 bg-opacity-30 border border-red-500 border-opacity-50 text-red-200">⚠️ Je hebt je limiet overschreden!</div>
                        @elseif($percentage > 100)
                            <div class="warning orange mt-3 px-3 py-2 rounded-md text-xs font-normal bg-yellow-600 bg-opacity-30 border border-yellow-500 border-opacity-50 text-yellow-200">⚠️ Let op: je nadert je limiet</div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <h2 class="text-gray-400 text-xl mb-4">Geschiedenis - Toegevoegde Producten</h2>
            <div id="dietist-historyContent">
                @php $hasHistory = false; @endphp
                @foreach($this->dailyData as $key => $value)
                    @if(str_ends_with($key, '_history') && count($value) > 0)
                        @php
                            $hasHistory = true;
                            $categoryKey = str_replace('_history', '', $key);
                            $goal = \App\Livewire\Dietist\Index::GOALS[$categoryKey] ?? null;
                            if (!$goal) continue;
                        @endphp
                        <div class="mb-6 bg-black bg-opacity-30 border border-white border-opacity-10 rounded-lg p-4">
                            <h3 class="text-gray-300 text-base font-medium mb-3 pb-2 border-b border-white border-opacity-10">{{ $goal['name'] }}</h3>
                            <div class="flex flex-col gap-2">
                                @foreach($value as $item)
                                    <div class="flex justify-between items-center py-2 px-3 bg-black bg-opacity-20 rounded-lg transition-all duration-200 hover:bg-opacity-30">
                                        <span class="text-gray-300 text-sm font-normal flex-1 truncate">{{ $item['name'] }}</span>
                                        <span class="text-blue-600 text-sm font-medium ml-4 whitespace-nowrap">{{ number_format($item['grams'], 0) }}{{ $goal['unit'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(!$hasHistory)
                    <div class="text-gray-400 italic py-5 text-center">Nog geen producten toegevoegd voor deze datum.</div>
                @endif
            </div>
        </div>

        <!-- Overzicht Tab -->
        <div id="dietist-overzicht" class="dietist-tab-content hidden">
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

            <h2 class="text-gray-400 text-xl mb-4">Dagelijks Overzicht - Grafiek</h2>
            <div class="chart-container relative h-[400px] flex justify-center items-center mb-6">
                <canvas id="dietist-nutritionChart"></canvas>
            </div>
        </div>

        <!-- Week Tab -->
        <div id="dietist-week" class="dietist-tab-content hidden">
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
    
    <!-- Hidden data elements for JavaScript to read fresh data -->
    <div id="dietist-daily-data" style="display: none;">@json($this->dailyData)</div>
    <div id="dietist-overview-data" style="display: none;">@json($this->overviewData)</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const DIETIST_GOALS = {
        groente: { name: 'Groente', max: 250, color: '#27ae60', unit: 'g' },
        fruit: { name: 'Fruit', max: 300, color: '#e74c3c', unit: 'g' },
        koolhydraten: { name: 'Koolhydraten', max: 495, color: '#f39c12', unit: 'g' },
        vlees: { name: 'Vlees', max: 100, color: '#e67e22', unit: 'g' },
        noten: { name: 'Ongezouten noten', max: 25, color: '#8e44ad', unit: 'g' },
        zuivel: { name: 'Zuivelproducten', max: 450, color: '#3498db', unit: 'g' },
        kaas: { name: 'Kaas', max: 40, color: '#f1c40f', unit: 'g' },
        vet: { name: 'Bereidingsvet', max: 15, color: '#95a5a6', unit: 'g' },
        vocht: { name: 'Vocht', max: 2000, color: '#00bcd4', unit: 'ml' }
    };

    let dietistCategoryCharts = {};
    let dietistOverviewChart = null;

    function switchDietistTab(tabName) {
        document.querySelectorAll('.dietist-tab-content').forEach(tab => {
            tab.classList.add('hidden');
            tab.classList.remove('block');
        });
        document.querySelectorAll('.dietist-tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('bg-gradient-to-r', 'from-[#000000]', 'via-[#0A0E1F]', 'to-[#102459]', 'text-white');
            btn.classList.add('bg-black', 'bg-opacity-30', 'border', 'border-white', 'border-opacity-10', 'text-gray-300');
        });
        
        const targetTab = document.getElementById('dietist-' + tabName);
        if (targetTab) {
            targetTab.classList.remove('hidden');
            targetTab.classList.add('block');
        }
        
        event.target.classList.add('active');
        event.target.classList.remove('bg-black', 'bg-opacity-30', 'border', 'border-white', 'border-opacity-10', 'text-gray-300');
        event.target.classList.add('bg-gradient-to-r', 'from-[#000000]', 'via-[#0A0E1F]', 'to-[#102459]', 'text-white');

        // Re-initialize charts when switching tabs
        setTimeout(() => {
            if (tabName === 'overzicht') {
                updateDietistOverviewChart();
            } else if (tabName === 'dagboek') {
                updateDietistCategoryCharts();
            }
        }, 150);
    }

    function updateDietistCategoryCharts() {
        // Get fresh data from the hidden JSON element
        const dataElement = document.getElementById('dietist-daily-data');
        if (!dataElement) return;
        
        const dailyData = JSON.parse(dataElement.textContent || '{}');
        
        @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
            const current = dailyData['{{ $key }}'] ?? 0;
            const max = {{ $goal['max'] }};
            createDietistCategoryChart('{{ $key }}', 'dietist-chart-{{ $key }}', current, max);
        @endforeach
    }

    function createDietistCategoryChart(key, canvasId, current, max) {
        let canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.warn('Canvas not found:', canvasId);
            return;
        }

        if (dietistCategoryCharts[key]) {
            dietistCategoryCharts[key].destroy();
            delete dietistCategoryCharts[key];
        }

        // Replace canvas with a fresh clone to clear any stale draws
        const clone = canvas.cloneNode(true);
        canvas.parentNode.replaceChild(clone, canvas);
        canvas = clone;
        canvas.style.borderRadius = '8px';
        const ctx = canvas.getContext('2d');
        const remaining = Math.max(0, max - current);
        
        // Ensure we have at least a small value for Chart.js to render properly
        const currentValue = Math.max(current, 0);
        const remainingValue = Math.max(remaining, 0);
        const total = currentValue + remainingValue;
        
        // If both are zero, use visible grays for empty state
        const data = total > 0 ? [currentValue, remainingValue] : [0.1, Math.max(max - 0.1, 0.1)];
        const colors = total > 0 ? ['#4c7fba', '#2c2c2e'] : ['#374151', '#1f2937']; // slate-700 + slate-800

        try {
            dietistCategoryCharts[key] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Gegeten', 'Resterend'],
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderColor: '#9ca3af',
                        borderWidth: 2.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: { duration: 0 },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1c1c1e',
                            titleColor: '#ffffff',
                            bodyColor: '#8e8e93',
                            borderColor: '#2c2c2e',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const unit = DIETIST_GOALS[key]?.unit || 'g';
                                    const value = context.parsed === 0.1 ? 0 : context.parsed;
                                    return `${context.label}: ${value}${unit}`;
                                }
                            }
                        }
                    }
                }
            });
            try { dietistCategoryCharts[key].resize(); } catch (e) {}
            try { dietistCategoryCharts[key].update('none'); } catch (e) {}
        } catch (error) {
            console.error('Error creating chart for', key, ':', error);
        }
    }

    function updateDietistOverviewChart() {
        const canvas = document.getElementById('dietist-nutritionChart');
        if (!canvas) return;

        if (dietistOverviewChart) {
            dietistOverviewChart.destroy();
        }

        // Get fresh data from the hidden JSON element
        const dataElement = document.getElementById('dietist-overview-data');
        if (!dataElement) return;
        
        const overviewData = JSON.parse(dataElement.textContent || '{}');

        // Replace canvas with a fresh clone to avoid stale renders
        const clone2 = canvas.cloneNode(true);
        canvas.parentNode.replaceChild(clone2, canvas);
        canvas = clone2;
        canvas.style.borderRadius = '8px';
        const ctx = canvas.getContext('2d');
        const labels = [];
        const values = [];
        const colors = [];

        @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
            const current = overviewData['{{ $key }}'] ?? 0;
            const percentage = (current / {{ $goal['max'] }} * 100);
            labels.push('{{ $goal['name'] }}');
            values.push(percentage);
            colors.push('{{ $goal['color'] }}');
        @endforeach

        dietistOverviewChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: '#9ca3af',
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: { duration: 0 },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12 },
                            color: '#8e8e93'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1c1c1e',
                        titleColor: '#ffffff',
                        bodyColor: '#8e8e93',
                        borderColor: '#2c2c2e',
                        borderWidth: 1
                    }
                }
            }
        });
        try { dietistOverviewChart.resize(); } catch (e) {}
        try { dietistOverviewChart.update('none'); } catch (e) {}
    }

    function initializeCharts() {
        const activeTab = document.querySelector('.dietist-tab-btn.active');
        if (activeTab) {
            const tabText = activeTab.textContent.trim();
            if (tabText === 'Dagboek') {
                updateDietistCategoryCharts();
            } else if (tabText === 'Overzicht') {
                updateDietistOverviewChart();
            }
        } else {
            // Default to Dagboek if no active tab (initial load)
            updateDietistCategoryCharts();
        }
    }

    // Initialize charts on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            initializeCharts();
        }, 300);
    });

    // Update charts when Livewire updates (Livewire 2)
    document.addEventListener('livewire:load', function() {
        setTimeout(() => {
            initializeCharts();
        }, 300);
        
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'dietist.index') {
                // Re-initialize charts after any component update
                setTimeout(() => {
                    initializeCharts();
                }, 300);
            }
        });
    });
    
    // Also listen for Livewire init (Livewire 3)
    document.addEventListener('livewire:init', () => {
        setTimeout(() => {
            initializeCharts();
        }, 300);
        
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'dietist.index') {
                // Re-initialize charts after any component update
                setTimeout(() => {
                    initializeCharts();
                }, 300);
            }
        });
    });
    
    // Additional hook for Livewire updates (covers all cases)
    document.addEventListener('livewire:update', () => {
        setTimeout(() => {
            initializeCharts();
        }, 300);
    });
</script>
