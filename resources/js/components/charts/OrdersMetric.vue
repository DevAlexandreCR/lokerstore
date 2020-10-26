<template>
    <div class="contaner-fluid">
        <canvas id="ordersChart"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js'
import Constants from "../../constants/constants"

export default {
    name: 'orders-metric',
    data()  {
        return {
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        }
    },
    props: {
        metrics: {
            type: Array,
            default: {}
        }
    },
    methods: {
        filterMetric(status) {
            let sends = this.metrics.filter(metric => metric.status === status)
            let metrics = []
            sends.forEach(metric => {
                let date = new Date(metric.date).getMonth()
                let total = metrics[date] ?? 0
                metrics[date] = total + metric.total
            })
            return metrics
        }
    },

    computed: {
        labels: function () {
            let months = []
            let date = new Date()
            let count = -1
            this.months.forEach(month => {
                if (date.getMonth() === count) return
                months.push(month)
                count++
            })
            return months
        },

        dataSent: function () {
            return this.filterMetric(Constants.ORDER_STATUS_SENT)
        },

        dataRejected: function () {
            return this.filterMetric(Constants.ORDER_STATUS_REJECTED)
        }
    },
    created() {

    },

    mounted() {
        let ctx = document.getElementById('ordersChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.labels,
                datasets: [{
                    label: 'Ventas Completadas',
                    data: this.dataSent,
                    backgroundColor: [
                        'rgba(155, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(13, 102, 255, 1)',
                        'rgba(153, 12, 25, 1)',
                        'rgba(25, 59, 4, 1)'
                    ],
                    borderColor: [
                        'rgba(155, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(7, 12, 12, 1)',
                        'rgba(13, 12, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(13, 102, 255, 1)',
                        'rgba(153, 12, 25, 1)',
                        'rgba(25, 59, 4, 1)',
                        'rgba(225, 159, 143, 1)'
                    ],
                    borderWidth: 3
                },{
                    label: 'Ventas Canceladas',
                    data: this.dataRejected,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
}
</script>
