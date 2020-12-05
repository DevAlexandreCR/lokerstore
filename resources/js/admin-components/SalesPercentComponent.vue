<template>
    <div class="flag flag-yellow ml-sm-2 shadow-sm mb-3 text-right">
        <div class="card-body">
            <small class="text-black-50 ">{{ __('reports.sales_last_month') }}<strong>{{salesLastMonthString}}</strong></small>
            <div class="progress">
                <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar"
                     :style="{'width': `${progress}%`}"
                     :aria-valuenow="salesThisMonth" aria-valuemin="0" :aria-valuemax="salesLastMonth">
                    {{ `${progress}%` }}
                </div>
            </div>
            <small class="text-black-50 float-left mb-2">{{ __('reports.sales_this_month') }}<strong>{{salesThisMonthString}}</strong></small>
        </div>
    </div>
</template>
<script>

export default {
  name: 'sales-percent-component',
  props: {
    metrics: {
      type: Array,
      default: () => []
    }
  },

  computed: {
    salesLastMonth: function () {
      const metrics = this.filterMetrics()
      return metrics[metrics.length - 2] ?? 0
    },

    salesThisMonth: function () {
      const metrics = this.filterMetrics()
      return metrics[metrics.length - 1] ?? 0
    },

    salesThisMonthString: function () {
      let value = this.salesThisMonth
      value = value.toString()
      value = value.split(/(?=(?:...)*$)/)
      value = value.join('.')
      return '$' + value
    },

    salesLastMonthString: function () {
      let value = this.salesLastMonth
      value = value.toString()
      value = value.split(/(?=(?:...)*$)/)
      value = value.join('.')
      return '$' + value
    },

    progress: function () {
      const percent = this.salesThisMonth / this.salesLastMonth * 100
      return Math.round(percent)
    }
  },

  methods: {
    filterMetrics () {
      const metrics = []
      this.metrics.forEach(metric => {
        const date = new Date(metric.date).getMonth()
        const total = metrics[date] ?? 0
        metrics[date] = total + parseInt(metric.amount)
      })

      return metrics.filter(metric => {
        return metric !== null
      })
    }
  }
}
</script>
