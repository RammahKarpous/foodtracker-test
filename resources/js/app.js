import './bootstrap';
import Chart from 'chart.js/auto';

window.Chart = Chart;

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js');
    });
}
