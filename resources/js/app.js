import 'bootstrap'
import Alpine from 'alpinejs'
import Chart from 'chart.js/auto'

window.Alpine = Alpine
window.Chart = Chart

// Chart.js global defaults
Chart.defaults.font.family = "'Inter', sans-serif"
Chart.defaults.font.size = 12
Chart.defaults.color = '#94A3B8'
Chart.defaults.plugins.legend.labels.boxWidth = 10
Chart.defaults.plugins.legend.labels.usePointStyle = true

Alpine.start()
