<template>
    <div style="position:relative" v-bind:class="{'open':openSuggestion}">
        <label for="searchProduct">{{ nameLabel }}</label>
        <input
            :class="styles"
            type="number"
            :name="nameInput"
            id="searchProduct"
            :value="value"
            @input="updateValue($event.target.value)"
            @keydown.enter="enter"
            @keydown.down="down($event)"
            @keydown.up="up($event)"
        />
        <ul class="list-group dropdown-menu shadow" v-show="open">
            <li class="list-group-item"
                v-for="(suggestion, index) in matches"
                :key="index"
                v-bind:class="{'active-autocomplete text-white': isActive(index)}"
                @click="suggestionClick(index)"
            >
                <a href="#"
                   v-bind:class="{'text-white': isActive(index)}"
                >{{ suggestion.reference }} <small>{{ suggestion.name }}</small>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

export default {

  name: 'autocomplete',

  data () {
    return {
      open: false,
      current: 0
    }
  },

  props: {
    value: {
      type: String,
      required: true
    },

    suggestions: {
      type: Array,
      required: true
    },

    nameInput: {
      type: String,
      default: 'reference',
      required: true
    },

    nameLabel: {
      type: String,
      default: 'products',
      required: true
    },

    styles: {
      type: String,
      required: true,
      default: 'form-control'
    }
  },

  computed: {

    matches () {
      return this.suggestions.filter((obj) => {
        if (obj.reference) return obj.reference.toString().indexOf(this.value) >= 0
      })
    },

    openSuggestion () {
      return this.selection !== '' &&
                this.matches.length !== 0 &&
                this.open === true
    }

  },

  methods: {

    // Triggered the input event to cascade the updates to
    // parent component
    updateValue (value) {
      if (this.open === false) {
        this.open = true
        this.current = 0
      }

      if (!value) {
        this.open = false
      }

      this.$emit('input', value)
    },

    // When enter key pressed on the input
    enter () {
      this.$emit('input', this.matches[this.current].reference.toString())
      this.$emit('select', this.matches[this.current])
      this.open = false
    },

    // When up arrow pressed while suggestions are open
    up (e) {
      e.preventDefault()
      if (this.current > 0) {
        this.current--
      }
    },

    // When down arrow pressed while suggestions are open
    down (e) {
      e.preventDefault()
      if (this.current < this.matches.length - 1) {
        this.current++
      }
    },

    // For highlighting element
    isActive (index) {
      return index === this.current
    },

    // When one of the suggestion is clicked
    suggestionClick (index) {
      this.$emit('input', this.matches[index].reference.toString())
      this.$emit('select', this.matches[index])
      this.open = false
    }
  }
}
</script>
