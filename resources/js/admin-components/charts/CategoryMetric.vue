<template>
    <div class="container-fluid">
        <canvas id="categoriesChart"></canvas>
    </div>
</template>

<script>

import Chart from 'chart.js'

export default {
  name: 'category-metric',
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
      const categories = []
      this.metrics.forEach(metric => {
        categories.push(metric.total)
      })
      return categories
    }
  },

  computed: {
    labels: function () {
      const ids = []
      this.metrics.forEach(metric => {
        ids.push(metric.measurable.name)
      })
      return ids
    },

    dataSells: function () {
      return this.filterMetric()
    }
  },

  mounted () {
    const ctx = document.getElementById('categoriesChart')
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: this.labels,
        datasets: [{
          data: this.dataSells,
          backgroundColor: [
            'rgba(255, 206, 86, 1)',
            'rgba(255, 0, 0, 1)',
            'rgba(153, 102, 255, 1)'
          ]
        }]
      },
      options: {
      }
    })
  }
}
</script>
