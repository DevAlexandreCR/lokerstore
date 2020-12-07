<template>
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('orders.details') }}</div>
            <div class="card-body">
                <table class="table table-condensed table-sm table-responsive" id="selectedProducts">
                    <thead>
                    <tr>
                        <th>{{ __('fields.products') }}</th>
                        <th>{{ __('fields.name') }}</th>
                        <th>{{ __('products.size') }}</th>
                        <th>{{ __('products.color') }}</th>
                        <th>{{ __('products.quantity') }}</th>
                        <th>{{ __('products.price') }}</th>
                        <th>{{ __('orders.total') }}</th>
                        <th>{{ __('actions.quit') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in selectedProducts" :key="index">
                        <td>{{ product.reference }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.stock.size.name }}</td>
                        <td class="text-lowercase">{{ product.stock.color.name }}</td>
                        <td>{{ product.quantity }}</td>
                        <td>{{ product.price | price }}</td>
                        <td>{{ product.quantity * product.price | price }}</td>
                        <td>
                            <button type="button" v-on:click="removeAll(index)" class="btn btn-danger btn-sm">
                                <ion-icon name="trash"></ion-icon>
                            </button>
                            <button v-show="product.quantity > 1" v-on:click="remove(index)" type="button"
                                    class="btn btn-dark btn-sm">
                                <ion-icon name="remove-circle"></ion-icon>
                            </button>
                        </td>
                    </tr>
                    <tr v-show="selectedProducts.length > 0">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-price float-left">{{ __('orders.subtotal') }}</td>
                        <td class="">{{ subTotal | price }}</td>
                        <td></td>
                    </tr>
                    <tr v-show="selectedProducts.length > 0">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-price float-left">{{ __('orders.tax') }}</td>
                        <td class="">{{ iva | price }}</td>
                        <td></td>
                    </tr>
                    <tr v-show="selectedProducts.length > 0">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-price float-left">{{ __('orders.amount') }}</td>
                        <td class="">{{ total | price }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-show="selectedProducts.length > 0">
                    <button type="button" class="btn btn-dark btn-sm btn-block" data-toggle="modal" data-target="#confirmOrder">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
        <confirm-order-component :products="selectedProducts" :total="total"></confirm-order-component>
    </div>
</template>

<script>

import NumberFormat from '../constants/NumberFormat'
import ConfirmOrderComponent from './ConfirmOrderComponent'

export default {
  name: 'order-table-component',
  components: { ConfirmOrderComponent },
  data () {
    return {
      subTotal: 0,
      iva: 0,
      total: 0
    }
  },

  props: {
    selectedProducts: {
      type: Array,
      default: () => [],
      required: true
    },

    count: {
      type: Number,
      default: 0,
      required: true
    }
  },

  watch: {
    count () {
      this.calculateTotals()
    }
  },

  methods: {
    removeAll (index) {
      this.selectedProducts.splice(index, 1)
      this.calculateTotals()
    },

    remove (index) {
      this.selectedProducts[index].quantity -= 1
      this.calculateTotals()
    },

    calculateTotals () {
      this.subTotal = 0
      this.selectedProducts.forEach(product => {
        const total = product.price * product.quantity
        this.subTotal += total
      })
      this.iva = this.subTotal * process.env.MIX_TAX ?? 0
      this.total = this.iva + this.subTotal
    }
  },

  filters: {
    price (price) {
      return NumberFormat.format(price)
    }
  }
}
</script>
