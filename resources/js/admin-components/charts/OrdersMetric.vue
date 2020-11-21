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
        return {}
    },
    props: {
        metrics: {
            type: Array,
            default: []
        }
    },
    methods: {
        filterMetric(status) {
            let sends = this.metrics.filter(metric => metric.status === status)
            let metrics = []
            sends.forEach(metric => {
                let date = new Date(metric.date).getMonth()
                let total = metrics[date] ?? 0
                metrics[date] = total +  parseInt(metric.amount)
            })
            return metrics.filter(metric => {
                return metric !== null
            })
        }
    },

    computed: {
        labels: function () {
            let today = new Date()
            let currentMonth = today.toLocaleString('default', { month: 'long' })
            let months = []
            this.metrics.forEach(metric => {
                let date = new Date(metric.date)
                let month = date.toLocaleString('default', { month: 'long' })
                if (!months.includes(month)) {
                    months.push(month)
                }
            })
            if(!months.includes(currentMonth)){
                this.metrics.push({
                    date: today,
                    amount: 0,
                    status:'sent'
                })
                this.metrics.push({
                    date: today,
                    amount: 0,
                    status:'canceled'
                })
                months.push(currentMonth)
            }
            return months
        },

        dataPaid: function () {
            return this.filterMetric(Constants.ORDER_STATUS_COMPLETED)
        },

        dataRejected: function () {
            return this.filterMetric(Constants.ORDER_STATUS_CANCELED)
        }
    },

    mounted() {
        let ctx = document.getElementById('ordersChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.labels,
                datasets: [{
                    label: this.__('reports.sales'),
                    data: this.dataPaid,
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
                    label: this.__('reports.sales_canceled'),
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
                            beginAtZero: true,
                            userCallback: function(value, index, values) {
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);
                                value = value.join('.');
                                return '$' + value;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart){
                            let datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            let value = tooltipItem.yLabel
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = value.join('.');
                            return datasetLabel + ': $ ' + value;
                        }
                    }
                }
            }
        });
    }
}
</script>
