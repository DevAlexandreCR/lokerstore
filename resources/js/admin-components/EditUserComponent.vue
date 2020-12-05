<template>
  <div class="container">
    <div class="card shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title">{{ __('users.data') }}</h5>
        <button class="btn" type="button">
          <a href="/admin/users">
            <ion-icon name="return-up-back-outline"></ion-icon>
          </a>
        </button>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <h6 class="card-title">{{ __('users.full_name') }}</h6>
          </div>
          <div class="col">
            <p @click="editingName = startEditing(editingName)" v-if="!editingName" class="card-text hover-edit">
              {{ user.name + ' ' + user.lastname }}</p>
            <div v-else class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationTooltip01">{{ __('users.name') }}</label>
                <input type="text" id="validationTooltip01" class="form-control" v-model="updateUser.name" required
                       autofocus>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationTooltip02">{{ __('users.last_name') }}</label>
                <input id="validationTooltip02" type="text" class="form-control" v-model="updateUser.lastname" required>
              </div>
            </div>
          </div>
          <div class="col-sm-2 d-flex align-items-center">
            <div class="btn-group  btn-group-sm "
                 role="group"
            >
              <form @submit.prevent="submit">
                <button type="submit" v-show="editingName" class="btn btn-primary">
                  <ion-icon name="save-outline"></ion-icon>
                </button>
              </form>
            </div>
            <button @click="editingName = startEditing(editingName)" v-show="editingName" class="btn btn-danger">
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title">{{ __('users.email') }}</h6>
          </div>
          <div class="col">
            <p @click="editingEmail = startEditing(editingEmail)" v-if="!editingEmail" class="card-text hover-edit">
              {{ user.email }}</p>
            <input v-else type="email" name="email" class="form-control" v-model="updateUser.email" autofocus required>
          </div>
          <div class="col-sm-2 d-flex align-items-center">
            <form @submit.prevent="submit">
              <button type="submit" v-show="editingEmail" class="btn btn-primary">
                <ion-icon name="save-outline"></ion-icon>
              </button>
            </form>
            <button @click="editingEmail = startEditing(editingEmail)" v-show="editingEmail" class="btn btn-danger">
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title"> {{ __('users.phone') }} </h6>
          </div>
          <div class="col">
            <p @click="editingPhone = startEditing(editingPhone)" v-if="!editingPhone" class="card-text hover-edit">
              {{ user.phone }}</p>
            <input v-else type="tel" name="phone" class="form-control" v-model="updateUser.phone" autofocus required>
          </div>
          <div class="col-sm-2 d-flex align-items-center">
            <form @submit.prevent="submit">
              <button type="submit" v-show="editingPhone" class="btn btn-primary">
                <ion-icon name="save-outline"></ion-icon>
              </button>
            </form>
            <button @click="editingPhone = startEditing(editingPhone)" v-show="editingPhone" class="btn btn-danger">
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title"> {{ __('users.address') }} </h6>
          </div>
          <div class="col">
            <p @click="editingAddress = startEditing(editingAddress)" v-if="!editingAddress"
               class="card-text hover-edit">{{ user.address }}</p>
            <input v-else type="text" name="address" class="form-control" v-model="updateUser.address" autofocus
                   required>
          </div>
          <div class="col-sm-2 d-flex align-items-center">
            <form @submit.prevent="submit">
              <button type="submit" v-show="editingAddress" class="btn btn-primary">
                <ion-icon name="save-outline"></ion-icon>
              </button>
            </form>
            <button @click="editingAddress = startEditing(editingAddress)" v-show="editingAddress"
                    class="btn btn-danger">
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title">{{ __('users.registration') }}</h6>
          </div>
          <div class="col">
            <p class="card-text">{{ user.created_at }}</p>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-link">
              <ion-icon name="lock-closed-outline"></ion-icon>
            </button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title"> {{ __('fields.status') }} </h6>
          </div>
          <div class="col">
            <p v-if="user.is_active" class="card-text">{{ __('actions.enabled') }}</p>
            <p v-else class="card-text">{{ __('actions.disabled') }}</p>
          </div>
          <div class="col-sm-2">
            <div class="btn-group  btn-group-sm "
                 role="group"
            >
              <form :action="user.id + '/edit'" method="get">
                <input type="hidden" name="p" value="is_active">
                <button class="btn btn-link" type="submit">
                  <ion-icon name="create-outline" class="bold"></ion-icon>
                </button>
              </form>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-3">
            <h6 class="card-title">{{ __('users.verified') }} </h6>
          </div>
          <div class="col">
            <p v-if="user.email_verified_at === null" class="card-text">{{ __('messages.no') }}</p>
            <p v-else class="card-text">{{ __('messages.yes') }}</p>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-link">
              <ion-icon name="lock-closed-outline"></ion-icon>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="btn-group  btn-group-sm "
                 role="group"
                 style="float: right; margin-bottom: -50%;">
              <form :action="user.id + '/edit'" method="get">
                <input type="hidden" name="p" value="delete">
                <button class="btn btn-danger rounded-circle shadow" type="submit">
                  <ion-icon name="trash" style="width: 30px; height: 30px;"></ion-icon>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios'

export default {
  name: 'edit-user-component',

  data () {
    return {
      editingName: false,
      editingEmail: false,
      editingPhone: false,
      editingAddress: false,
      updateUser: {
        name: this.user.name,
        lastname: this.user.lastname,
        email: this.user.email,
        phone: this.user.phone,
        address: this.user.address
      }
    }
  },

  props: {
    user: {
      default: {
        type: String,
        name: ''
      }
    }
  },

  methods: {
    startEditing (inputName) {
      return !inputName
    },

    submit () {
      axios.put(this.user.id, {
        user: {
          name: this.updateUser.name,
          lastname: this.updateUser.lastname,
          email: this.updateUser.email,
          phone: this.updateUser.phone,
          address: this.updateUser.address
        }
      })
        .then(() => {
          this.editingName = false
          this.editingEmail = false
          this.editingPhone = false
          this.editingAddress = false
        })
        .catch(e => {
          alert(e.message)
        })
    }
  }
}
</script>
