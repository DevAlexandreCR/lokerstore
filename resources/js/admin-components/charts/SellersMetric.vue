<template>
    <div class="container-fluid">
        <canvas id="sellersChart"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js'

export default {
  name: 'sellers-metric',
  data () {
    return {
    }
  },
  props: {
    metrics: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    filterMetric () {
      const sells = []
      this.metrics.forEach(metric => {
        sells.push(parseInt(metric.amount))
      })
      return sells
    }
  },

  computed: {
    labels: function () {
      const ids = []
      this.metrics.forEach(metric => {
        if (metric.measurable) {
          ids.push(metric.measurable.name)
        } else {
          ids.push('Online')
        }
      })
      return ids
    },

    dataSells: function () {
      return this.filterMetric()
    }
  },

  mounted () {
    const ctx = document.getElementById('sellersChart')
    new Chart(ctx, {
      type: 'horizontalBar',
      data: {
        labels: this.labels,
        datasets: [{
          label: this.__('reports.best_seller'),
          data: this.dataSells,
          backgroundColor: [
            'rgba(15, 99, 12, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(200, 26, 16, 1)',
            'rgba(55, 20, 96, 1)',
            'rgba(0, 255, 1, 1)'
          ]
        }]
      },
      options: {
        responsive: true,
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true
            },
            ticks: {
              beginAtZero: true
            },
            stacked: true
          }],
          xAxes: [{
            scaleLabel: {
              display: false,
              labelString: this.__('reports.sales')
            },
            stacked: true,
            ticks: {
              beginAtZero: true,
              userCallback: function (value) {
                value = value.toString()
                value = value.split(/(?=(?:...)*$)/)
                value = value.join('.')
                return '$' + value
              }
            }
          }]
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, chart) {
              const datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || ''
              let value = tooltipItem.xLabel
              value = value.toString()
              value = value.split(/(?=(?:...)*$)/)
              value = value.join('.')
              return datasetLabel + ': $ ' + value
            }
          }
        }
      }
    })
  }
}
</script>
