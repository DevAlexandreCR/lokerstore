<template>
    <div class="card">
        <div class="card-header">{{ __('payment.add') }}</div>
        <div class="card-body">
            <form :action="url" method="post">
                <input type="hidden" name="_token" id="csrf-token" :value="token">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group form-row">
                            <label class="col-sm-7" for="selectMethod">{{ __('payment.method') }}</label>
                            <select class="form-control col-sm-5 form-control-sm" id="selectMethod" name="method">
                                <option v-for="(method, index) in methods" :key="index" :value="method">{{ method }}</option>
                            </select>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-sm-8" for="selectType">Tipo de documento</label>
                            <select class="form-control col-sm-4 form-control-sm" id="selectType" name="document_type">
                                <option v-for="(type,index) in documentTypes" :key="index" :value="type">{{ type }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <autocomplete :suggestions="suggestions" v-model="selection" v-on:select="selectPayer"
                                          :name-input="'document'" :name-label="__('payer.document')" :styles="'form-control form-control-sm'">
                            </autocomplete>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group form-row">
                            <label class="col-sm-2" for="namePayer">{{ __('fields.name') }}</label>
                            <input type="text" class="form-control col-sm-4 form-control-sm" name="name" :value="payer.name"
                                   id="namePayer" placeholder="Pepito">
                            <label class="col-sm-2" for="lastNamePayer">{{ __('users.last_name') }}</label>
                            <input type="text" class="form-control col-sm-4 form-control-sm" name="lastName" :value="payer.last_name"
                                   id="lastNamePayer" placeholder="Perez">
                        </div>
                        <div class="form-group form-row">
                            <label class="col-sm-2" for="emailPayer">{{ __('users.email') }}</label>
                            <input type="email" class="form-control col-sm-4 form-control-sm" id="emailPayer"
                                   name="email" :value="payer.email"
                                   placeholder="client@example.com">
                            <label class="col-sm-2" for="phonePayer">{{ __('users.phone') }}</label>
                            <input type="text" class="form-control col-sm-4 form-control-sm" id="phonePayer"
                                   name="phone" :value="payer.phone"
                                   placeholder="3103100000">
                        </div>
                        <div class="form-group text-center align-bottom">
                            <label class="title" for="amountOrder">{{ __('orders.amount') }}</label>
                            <input type="text" class="form-control form-control-sm text-center" disabled
                                   id="amountOrder" :value="amount | price">
                        </div>
                        <input type="hidden" name="order_id" :value="orderId">
                        <input type="hidden" name="amount" :value="amount">
                    </div>
                    <div class="btn-group btn-block mx-xl-5">
                        <button type="submit" class="btn btn-success btn-sm">{{ __('actions.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import * as Payments from '../constants/Payments'
import * as Payers from '../constants/Payers'
import Autocomplete from './Autocomplete'
import NumberFormat from '../constants/NumberFormat'
import $ from 'jquery'

export default {
  name: 'add-payment-component',
  components: { Autocomplete },
  data () {
    return {
      methods: Payments.all(),
      documentTypes: Payers.all(),
      suggestions: [],
      selection: '',
      payer: {},
      token: $('meta[name="csrf-token"]').attr('content'),
      url: process.env.MIX_APP_URL + '/admin/payments/store'
    }
  },

  props: {
    payers: {
      type: Array,
      default: () => [],
      required: true
    },

    orderId: {
      type: Number,
      required: true
    },

    amount: {
      type: Number,
      default: 0,
      required: true
    }
  },

  methods: {
    selectPayer (payer) {
      this.payer = payer
    }
  },

  filters: {
    price (price) {
      return NumberFormat.format(price)
    }
  },

  created () {
    this.payers.forEach(payer => {
      payer.reference = payer.document
      payer.name = `${payer.name} ${payer.last_name}`
      this.suggestions.push(payer)
    })
  }
}
</script>
