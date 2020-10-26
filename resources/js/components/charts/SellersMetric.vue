<template>
    <div class="contaner-fluid">
        <canvas id="sellersChart"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js'

export default {
    name: 'sellers-metric',
    data()  {
        return {
        }
    },
    props: {
        metrics: {
            type: Array,
            default: {}
        }
    },
    methods: {
        filterMetric() {
            let sells = []
            this.metrics.forEach(metric => {
                let id = metric.measurable_id ?? 0
                let total = sells[id.toString()] ?? 0
                sells[id] = total + metric.total
            })

            return sells.filter(function (value) {return value != null})
        }
    },

    computed: {
        labels: function () {
            let ids = []
            this.metrics.forEach(metric => {
                let id = metric.measurable_id ?? 0
                if (!ids.includes(id)) {
                    ids[id] = id
                }
            })
            return ids.filter(function (value) {return value != null})
        },

        dataSells: function () {
            return this.filterMetric()
        }
    },
    created() {

    },

    mounted() {
        let ctx = document.getElementById('sellersChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.labels,
                datasets: [{
                    label: 'Ventas este mes',
                    data: this.dataSells,
                    backgroundColor: [
                        'rgba(15, 99, 12, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(200, 26, 16, 1)',
                        'rgba(55, 20, 96, 1)',
                        'rgba(245, 6, 249, 1)',
                        'rgba(5, 60, 59, 1)',
                        'rgba(25, 86, 199, 1)',
                    ],
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
