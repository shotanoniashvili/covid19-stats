<template>
    <router-view />
</template>

<script>
import '@popperjs/core'
import AuthResource from './api/authResource'
import axios from 'axios'

const resource = new AuthResource()

export default {
    name: 'app',

    mounted () {
        this.setLocale()

        axios.interceptors.response.use(undefined, err => new Promise(() => {
            if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
                this.$store.dispatch('auth/setUser', { user: null, token: null })
            }

            throw err
        }))

        if (localStorage.getItem('token')) {
            this.checkLogin()
        }
    },

    methods: {
        setLocale () {
            const locale = localStorage.getItem('locale')
            if (locale) {
                this.$store.dispatch('localization/setLocale', locale)
            }
        },

        checkLogin () {
            resource.user()
            .then(response => {
                this.$store.dispatch('auth/setUser', {
                    user: response.data.user,
                    token: localStorage.getItem('token')
                })
            }).catch(() => {
                localStorage.removeItem('token')
                this.$router.push('/login')
            })
        }
    }
}
</script>
