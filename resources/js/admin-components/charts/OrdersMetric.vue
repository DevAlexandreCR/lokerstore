<template>
    <div class="container-fluid">
        <canvas id="ordersChart"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js'
import * as Constants from '../../constants/Constants'

export default {
  name: 'orders-metric',
  data () {
    return {
      metrics: this.orders
    }
  },
  props: {
    orders: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    filterMetric (status) {
      const sends = this.metrics.filter(metric => metric.status === status)
      const metrics = []
      sends.forEach(metric => {
        const date = new Date(metric.date).getMonth()
        const total = metrics[date] ?? 0
        metrics[date] = total + parseInt(metric.amount)
      })
      return metrics.filter(metric => {
        return metric !== null
      })
    },
    addCurrentMonth (today) {
      this.metrics.push({
        date: today,
        amount: 0,
        status: 'sent'
      })
      this.metrics.push({
        date: today,
        amount: 0,
        status: 'canceled'
      })
    }
  },

  computed: {
    labels: function () {
      const today = new Date()
      const currentMonth = today.toLocaleString('default', { month: 'long' })
      const months = []
      this.metrics.forEach(metric => {
        const date = new Date(metric.date)
        const month = date.toLocaleString('default', { month: 'long' })
        if (!months.includes(month)) {
          months.push(month)
        }
      })
      if (!months.includes(currentMonth)) {
        this.addCurrentMonth(today)
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

  mounted () {
    const ctx = document.getElementById('ordersChart')
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
        }, {
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
              userCallback: function (value, index, values) {
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
              let value = tooltipItem.yLabel
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
