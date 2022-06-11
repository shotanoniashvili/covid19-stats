<template>
    <select @input="handleChange" v-model="lang" class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
        <option value="ka">ქართული</option>
        <option value="en">English</option>
    </select>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "LanguageSwitcher",

    data() {
        return {
            lang: ''
        }
    },

    computed: {
        ...mapGetters({
            locale: 'localization/locale'
        })
    },

    mounted() {
        this.lang = this.locale
    },

    methods: {
        handleChange($event) {
            this.$store.dispatch('localization/setLocale', $event.target.value)
            window.location.reload()
        }
    }
}
</script>
