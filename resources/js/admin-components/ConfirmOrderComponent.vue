<template>
    <div class="modal" tabindex="-1" id="confirmOrder">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('orders.save') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed table-sm">
                        <thead>
                        <tr>
                            <th>{{ __('orders.amount') }}</th>
                            <td>{{ total | price }}</td>
                        </tr>
                        <tr>
                            <th class="align-middle">{{ __('payment.apply_discount') }}</th>
                            <td class="align-middle">
                                <div class="input-group">
                                    <input type="number" class="form-control align-middle" placeholder="0" aria-label="Total"
                                           @input="applyDiscount($event.target.value)"
                                           :value="discount"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-sm" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('orders.amount') }}</th>
                            <td>{{ amount | price }}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.close') }}</button>
                    <button type="button" class="btn btn-primary" @click="sendRequest">Si</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NumberFormat from '../constants/NumberFormat'
import axios from 'axios'

export default {
  name: 'confirm-order-component',
  data () {
    return {
      discount: 0,
      amount: 0,
      url: process.env.MIX_APP_URL + '/admin/orders'
    }
  },

  props: {
    products: {
      type: Array,
      default: () => [],
      required: true
    },
    total: {
      type: Number,
      default: 0,
      required: true
    }
  },

  watch: {
    total: function () {
      this.amount = this.total - (this.total * this.discount / 100)
    }
  },

  methods: {
    applyDiscount (value) {
      this.discount = value
      this.amount = this.total - (this.total * this.discount / 100)
    },

    sendRequest () {
      const data = {}
      data.details = []
      this.products.forEach(product => {
        data.amount = this.amount
        data.details.push({
          stock_id: product.stock.id,
          quantity: product.quantity
        })
      })
      axios.post(this.url, data).then((res) => {
        window.location.href = res.request.responseURL
      }).catch(err => {
        alert(err.response.data)
      })
    }
  },

  filters: {
    price (price) {
      return NumberFormat.format(price)
    }
  }
}
</script>
