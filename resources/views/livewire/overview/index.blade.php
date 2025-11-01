<div class="w-full" x-data="chartData()">
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
    
    <div class="flex flex-wrap gap-6 justify-center mb-6">
        @php
            $totals = $this->totals;
            $limits = $this->limits;
        @endphp
        
        <canvas id="chart-kcal" width="200" height="200"></canvas>
        <canvas id="chart-vet" width="200" height="200"></canvas>
        <canvas id="chart-verzadigd" width="200" height="200"></canvas>
        <canvas id="chart-kh" width="200" height="200"></canvas>
        <canvas id="chart-suiker" width="200" height="200"></canvas>
        <canvas id="chart-eiwit" width="200" height="200"></canvas>
    </div>
    
    <script>
        function chartData() {
            return {
                init() {
                    this.initCharts();
                },
                initCharts() {
                    @php
                        $chartData = [
                            ['id' => 'chart-kcal', 'label' => 'Kcal', 'value' => $totals['kcal'], 'max' => $limits['kcal']],
                            ['id' => 'chart-vet', 'label' => 'Vet (g)', 'value' => $totals['vet'], 'max' => $limits['vet']],
                            ['id' => 'chart-verzadigd', 'label' => 'Verzadigd vet (g)', 'value' => $totals['verzadigd'], 'max' => $limits['verzadigd']],
                            ['id' => 'chart-kh', 'label' => 'Koolhydraten (g)', 'value' => $totals['koolhydraten'], 'max' => $limits['koolhydraten']],
                            ['id' => 'chart-suiker', 'label' => 'Suiker (g)', 'value' => $totals['suiker'], 'max' => $limits['suiker']],
                            ['id' => 'chart-eiwit', 'label' => 'Eiwit (g)', 'value' => $totals['eiwit'], 'max' => $limits['eiwit']],
                        ];
                    @endphp
                    const data = @json($chartData);
                    
                    data.forEach(item => {
                        const ctx = document.getElementById(item.id).getContext('2d');
                        const gegeten = Math.min(item.value, item.max);
                        const resterend = Math.max(item.max - item.value, 0);
                        const mainLabel = `${item.label} (${item.value.toFixed(1)}/${item.max})`;
                        
                        let backgroundColor;
                        if (item.value > item.max) {
                            backgroundColor = ['#c62828', '#444'];
                        } else if (item.value === 0) {
                            backgroundColor = ['#000000', '#000000'];
                        } else {
                            const gradient = ctx.createLinearGradient(0, 0, 120, 120);
                            gradient.addColorStop(0, '#0B0D14');
                            gradient.addColorStop(0.5, '#0D142A');
                            gradient.addColorStop(1, '#123072');
                            backgroundColor = [gradient, '#000000'];
                        }
                        
                        new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: [mainLabel, 'Resterend'],
                                datasets: [{
                                    data: [gegeten, resterend],
                                    backgroundColor: backgroundColor,
                                    borderColor: '#606672',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom',
                                        labels: {
                                            color: '#606672',
                                            font: { weight: '500', size: 14 }
                                        }
                                    }
                                },
                                responsive: false
                            }
                        });
                    });
                }
            }
        }
    </script>
</div>
