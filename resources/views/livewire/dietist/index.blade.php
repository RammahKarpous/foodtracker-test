<div class="bg-black min-h-screen text-[#8e8e93] font-sans">
    <div class="container max-w-full mx-auto">
        <header class="bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-5 border-b border-[rgba(139,101,60,0.3)] mb-0 text-center">
            <h1 class="text-white text-2xl mb-5 font-semibold">KMD's foodtracker</h1>
            <div class="dietist-tabs flex gap-2.5 justify-center mb-5 px-5 overflow-x-auto -webkit-overflow-scrolling-touch">
                <button class="dietist-tab-btn active bg-[rgba(30,58,138,0.6)] text-white border border-[rgba(59,130,246,0.5)] px-5 py-2.5 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300" onclick="switchDietistTab('dagboek')">Dagboek</button>
                <button class="dietist-tab-btn bg-[rgba(28,28,30,0.6)] text-[#8e8e93] border border-[rgba(139,101,60,0.3)] px-5 py-2.5 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300" onclick="switchDietistTab('overzicht')">Overzicht</button>
                <button class="dietist-tab-btn bg-[rgba(28,28,30,0.6)] text-[#8e8e93] border border-[rgba(139,101,60,0.3)] px-5 py-2.5 rounded-lg text-sm font-medium cursor-pointer transition-all duration-300" onclick="switchDietistTab('week')">Weekoverzicht</button>
            </div>
        </header>

        <!-- Dagboek Tab -->
        <div id="dietist-dagboek" class="dietist-tab-content block">
            <div class="bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] border-b border-[rgba(139,101,60,0.3)] py-4 px-5">
                <div class="date-selector flex items-center justify-center gap-5 mb-5">
                    <button wire:click="changeDay(-1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">‹</button>
                    <div class="date-display text-[#8e8e93] text-base font-normal text-center min-w-[250px]">{{ $this->formatDate($selectedDate) }}</div>
                    <button wire:click="changeDay(1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">›</button>
                </div>
            </div>

            <div class="categories-grid flex flex-nowrap gap-4 mb-5 p-4 bg-black overflow-x-auto -webkit-overflow-scrolling-touch snap-x snap-proximity md:grid md:grid-cols-[repeat(auto-fit,minmax(280px,1fr))] md:flex-wrap">
                @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                    @php
                        $current = $this->dailyData[$key] ?? 0;
                        $remaining = max(0, $goal['max'] - $current);
                        $percentage = ($current / $goal['max'] * 100);
                        $color = $percentage <= 100 ? 'green' : ($percentage <= 110 ? 'orange' : 'red');
                    @endphp
                    <div class="category-card {{ $color }} bg-[rgba(28,28,30,0.7)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-5 rounded-2xl border border-[rgba(139,101,60,0.4)] transition-all duration-300 shadow-[0_8px_32px_rgba(0,0,0,0.4)] flex-none min-w-[280px] snap-start md:min-w-0 md:flex-auto hover:bg-[rgba(28,28,30,0.85)] hover:border-[rgba(139,101,60,0.6)] hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(139,101,60,0.2)]">
                        <h3 class="text-base mb-4 text-white text-center font-medium">{{ $goal['name'] }}</h3>
                        <div class="category-chart w-[140px] h-[140px] mx-auto mb-4">
                            <canvas id="dietist-chart-{{ $key }}"></canvas>
                        </div>
                        <div class="category-info flex flex-col gap-2 text-sm">
                            <div class="info-row flex justify-between">
                                <span class="info-label text-[#8e8e93] font-normal">Gegeten:</span>
                                <span class="info-value font-medium text-white">{{ number_format($current, 0) }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-[#8e8e93] font-normal">Maximaal:</span>
                                <span class="info-value font-medium text-white">{{ $goal['max'] }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-[#8e8e93] font-normal">Resterend:</span>
                                <span class="info-value font-medium text-white">{{ number_format($remaining, 0) }}{{ $goal['unit'] }}</span>
                            </div>
                            <div class="info-row flex justify-between">
                                <span class="info-label text-[#8e8e93] font-normal">Percentage:</span>
                                <span class="info-value font-medium text-white">{{ number_format($percentage, 1) }}%</span>
                            </div>
                        </div>
                        @if($percentage > 110)
                            <div class="warning red mt-2.5 px-3 py-2 rounded-md text-xs font-normal backdrop-blur-[10px] -webkit-backdrop-blur-[10px] bg-[rgba(231,76,60,0.2)] text-[#e74c3c] border border-[rgba(231,76,60,0.4)]">⚠️ Je hebt je limiet overschreden!</div>
                        @elseif($percentage > 100)
                            <div class="warning orange mt-2.5 px-3 py-2 rounded-md text-xs font-normal backdrop-blur-[10px] -webkit-backdrop-blur-[10px] bg-[rgba(243,156,18,0.2)] text-[#f39c12] border border-[rgba(243,156,18,0.4)]">⚠️ Let op: je nadert je limiet</div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="history-section bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-6 border-t border-[rgba(139,101,60,0.3)] mt-5">
                <h2 class="text-white text-lg font-medium mb-5">Geschiedenis - Toegevoegde Producten</h2>
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
                            <div class="history-category mb-6 bg-[rgba(28,28,30,0.6)] backdrop-blur-[10px] -webkit-backdrop-blur-[10px] p-4 rounded-xl border border-[rgba(139,101,60,0.3)]">
                                <h3 class="text-white text-base font-medium mb-3 pb-2 border-b border-[rgba(139,101,60,0.2)]">{{ $goal['name'] }}</h3>
                                <div class="history-list flex flex-col gap-2">
                                    @foreach($value as $item)
                                        <div class="history-item flex justify-between items-center py-2.5 px-3 bg-[rgba(0,0,0,0.3)] rounded-lg border-l-4 border-[rgba(139,101,60,0.5)] transition-all duration-200 hover:bg-[rgba(0,0,0,0.5)] hover:border-[rgba(139,101,60,0.8)]">
                                            <span class="history-item-name text-white font-normal flex-1">{{ $item['name'] }}</span>
                                            <span class="history-item-grams text-[#4c7fba] font-medium ml-4">{{ number_format($item['grams'], 0) }}{{ $goal['unit'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @if(!$hasHistory)
                        <div class="history-empty text-[#8e8e93] italic py-5 text-center">Nog geen producten toegevoegd voor deze datum.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Overzicht Tab -->
        <div id="dietist-overzicht" class="dietist-tab-content hidden">
            <div class="chart-section bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-6 rounded-none border-t border-[rgba(139,101,60,0.3)]">
                <h2 class="mb-5 text-white text-center text-lg font-medium">Dagelijks Overzicht - Tabel</h2>
                <div class="bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] border-b border-[rgba(139,101,60,0.3)] py-4 px-5 mb-5">
                    <div class="date-selector flex items-center justify-center gap-5 mb-5">
                        <button wire:click="changeOverviewDay(-1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">‹</button>
                        <div class="date-display text-[#8e8e93] text-base font-normal text-center min-w-[250px]">{{ $this->formatDate($overviewDate) }}</div>
                        <button wire:click="changeOverviewDay(1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">›</button>
                    </div>
                </div>
                <div class="overflow-x-auto -webkit-overflow-scrolling-touch mb-8">
                    <table class="w-full border-collapse min-w-[600px]">
                        <thead>
                            <tr>
                                <th class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-[#8e8e93] font-medium text-sm">Categorie</th>
                                <th class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-[#8e8e93] font-medium text-sm">Gegeten</th>
                                <th class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-[#8e8e93] font-medium text-sm">Doel</th>
                                <th class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-[#8e8e93] font-medium text-sm">Voortgang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                                @php
                                    $current = $this->overviewData[$key] ?? 0;
                                    $percentage = ($current / $goal['max'] * 100);
                                    $progressClass = $percentage > 110 ? 'danger' : ($percentage > 100 ? 'warning' : '');
                                    $progressColor = $progressClass === 'danger' ? '#e74c3c' : ($progressClass === 'warning' ? '#f39c12' : '#4c7fba');
                                @endphp
                                <tr>
                                    <td class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-white text-sm">{{ $goal['name'] }}</td>
                                    <td class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-white text-sm">{{ number_format($current, 0) }}{{ $goal['unit'] }}</td>
                                    <td class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-white text-sm">{{ $goal['max'] }}{{ $goal['unit'] }}</td>
                                    <td class="p-3 text-left border-b border-[rgba(139,101,60,0.2)] text-white text-sm">
                                        <div>{{ number_format($percentage, 1) }}%</div>
                                        <div class="progress-bar w-full h-2 bg-[#2c2c2e] rounded-[10px] overflow-hidden mt-1.5">
                                            <div class="progress-fill {{ $progressClass }} h-full rounded-[10px] transition-all duration-300" style="background: {{ $progressColor }}; width: {{ min($percentage, 100) }}%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h2 class="mb-5 text-white text-center text-lg font-medium">Dagelijks Overzicht - Grafiek</h2>
                <div class="chart-container relative h-[400px] flex justify-center items-center">
                    <canvas id="dietist-nutritionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Week Tab -->
        <div id="dietist-week" class="dietist-tab-content hidden">
            <div class="chart-section bg-[rgba(28,28,30,0.8)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-6 rounded-none border-t border-[rgba(139,101,60,0.3)]">
                <h2 class="mb-5 text-white text-center text-lg font-medium">Weekoverzicht (Ma - Vr)</h2>
                <div class="date-selector flex items-center justify-center gap-5 mb-6">
                    <button wire:click="changeWeek(-1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">‹</button>
                    <div class="date-display text-[#8e8e93] text-base font-normal text-center min-w-[250px]" id="dietist-weekDisplay">{{ $this->formatWeekDisplay() }}</div>
                    <button wire:click="changeWeek(1)" class="date-nav-btn bg-transparent text-[#4c7fba] border-none py-1.5 px-4 text-4xl cursor-pointer transition-all duration-200 font-light leading-none">›</button>
                </div>
                @php
                    $redMeatTotal = $this->weeklyRedMeatTotal;
                    $redMeatPercentage = ($redMeatTotal / \App\Livewire\Dietist\Index::RED_MEAT_WEEKLY_LIMIT * 100);
                    $redMeatClass = $redMeatPercentage > 100 ? 'danger' : ($redMeatPercentage > 80 ? 'warning' : '');
                    $redMeatValueColor = $redMeatClass === 'danger' ? '#e74c3c' : ($redMeatClass === 'warning' ? '#f39c12' : '#ffffff');
                    $redMeatProgressColor = $redMeatClass === 'danger' ? '#e74c3c' : ($redMeatClass === 'warning' ? '#f39c12' : '#4c7fba');
                @endphp
                <div class="red-meat-info {{ $redMeatClass }} bg-[rgba(28,28,30,0.6)] backdrop-blur-[10px] -webkit-backdrop-blur-[10px] py-4 px-5 rounded-xl border border-[rgba(139,101,60,0.3)] mb-6 text-center">
                    <h3 class="text-white text-base font-medium mb-2.5">Rood Vlees - Weeklimiet</h3>
                    <div class="red-meat-stats flex justify-between items-center text-[#8e8e93] text-sm">
                        <span>Gegeten:</span>
                        <span class="red-meat-value font-medium" style="color: {{ $redMeatValueColor }};">{{ number_format($redMeatTotal, 0) }}g / {{ \App\Livewire\Dietist\Index::RED_MEAT_WEEKLY_LIMIT }}g</span>
                    </div>
                    <div class="red-meat-progress w-full h-2 bg-[#2c2c2e] rounded-[10px] overflow-hidden mt-2.5">
                        <div class="red-meat-progress-fill {{ $redMeatClass }} h-full rounded-[10px] transition-all duration-300" style="background: {{ $redMeatProgressColor }}; width: {{ min($redMeatPercentage, 100) }}%;"></div>
                    </div>
                </div>
                <div class="week-grid grid grid-cols-1 md:grid-cols-5 gap-4 p-4 overflow-x-auto -webkit-overflow-scrolling-touch">
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
                        <div class="day-card bg-[rgba(28,28,30,0.7)] backdrop-blur-[20px] -webkit-backdrop-blur-[20px] p-4 rounded-xl border border-[rgba(139,101,60,0.4)] text-center min-w-[200px]">
                            <h3 class="text-white text-base mb-2.5 font-medium">{{ $dayNames[$i] }}</h3>
                            <div class="day-date text-[#8e8e93] text-xs mb-2.5">{{ $date->day }}/{{ $date->month }}</div>
                            <div class="day-summary flex flex-col gap-1 text-xs">
                                @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
                                    @php
                                        $current = $dayData[$key] ?? 0;
                                        $percentage = ($current / $goal['max'] * 100);
                                    @endphp
                                    <div class="day-summary-item flex justify-between text-[#8e8e93]">
                                        <span>{{ $goal['name'] }}:</span>
                                        <span class="day-summary-value text-white">{{ number_format($percentage, 0) }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
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
            btn.classList.remove('bg-[rgba(30,58,138,0.6)]', 'text-white', 'border-[rgba(59,130,246,0.5)]');
            btn.classList.add('bg-[rgba(28,28,30,0.6)]', 'text-[#8e8e93]', 'border-[rgba(139,101,60,0.3)]');
        });
        
        const targetTab = document.getElementById('dietist-' + tabName);
        if (targetTab) {
            targetTab.classList.remove('hidden');
            targetTab.classList.add('block');
        }
        
        event.target.classList.add('active');
        event.target.classList.remove('bg-[rgba(28,28,30,0.6)]', 'text-[#8e8e93]', 'border-[rgba(139,101,60,0.3)]');
        event.target.classList.add('bg-[rgba(30,58,138,0.6)]', 'text-white', 'border-[rgba(59,130,246,0.5)]');

        if (tabName === 'overzicht') {
            setTimeout(() => {
                updateDietistOverviewChart();
            }, 100);
        } else if (tabName === 'dagboek') {
            setTimeout(() => {
                updateDietistCategoryCharts();
            }, 100);
        }
    }

    function updateDietistCategoryCharts() {
        @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
            @php
                $current = $this->dailyData[$key] ?? 0;
                $max = $goal['max'];
            @endphp
            createDietistCategoryChart('{{ $key }}', 'dietist-chart-{{ $key }}', {{ $current }}, {{ $max }});
        @endforeach
    }

    function createDietistCategoryChart(key, canvasId, current, max) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.warn('Canvas not found:', canvasId);
            return;
        }

        if (dietistCategoryCharts[key]) {
            dietistCategoryCharts[key].destroy();
            delete dietistCategoryCharts[key];
        }

        const ctx = canvas.getContext('2d');
        const remaining = Math.max(0, max - current);
        
        // Ensure we have at least a small value for Chart.js to render properly
        const currentValue = Math.max(current, 0);
        const remainingValue = Math.max(remaining, 0);
        const total = currentValue + remainingValue;
        
        // If both are zero, use a small value to show empty state
        const data = total > 0 ? [currentValue, remainingValue] : [0.1, max - 0.1];
        const colors = total > 0 ? ['#4c7fba', '#2c2c2e'] : ['#2c2c2e', '#2c2c2e'];

        try {
            dietistCategoryCharts[key] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Gegeten', 'Resterend'],
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
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

        const ctx = canvas.getContext('2d');
        const labels = [];
        const values = [];
        const colors = [];

        @foreach(\App\Livewire\Dietist\Index::GOALS as $key => $goal)
            @php
                $current = $this->overviewData[$key] ?? 0;
                $percentage = ($current / $goal['max'] * 100);
            @endphp
            labels.push('{{ $goal['name'] }}');
            values.push({{ number_format($percentage, 1) }});
            colors.push('{{ $goal['color'] }}');
        @endforeach

        dietistOverviewChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
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
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            updateDietistCategoryCharts();
        }, 200);
    });

    // Update charts when Livewire updates
    document.addEventListener('livewire:load', function() {
        setTimeout(() => {
            updateDietistCategoryCharts();
        }, 200);
        
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'dietist.index') {
                setTimeout(() => {
                    const activeTab = document.querySelector('.dietist-tab-btn.active');
                    if (activeTab && activeTab.textContent.trim() === 'Dagboek') {
                        updateDietistCategoryCharts();
                    } else if (activeTab && activeTab.textContent.trim() === 'Overzicht') {
                        updateDietistOverviewChart();
                    }
                }, 200);
            }
        });
    });
    
    // Also listen for Livewire init (for Livewire 3)
    document.addEventListener('livewire:init', () => {
        setTimeout(() => {
            updateDietistCategoryCharts();
        }, 200);
    });
</script>
