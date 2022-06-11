<template>
    <section class="h-screen">
        <div class="container mx-auto px-6 py-12 h-full">
            <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
                <div class="md:w-8/12 lg:w-6/12 mb-12 md:mb-0">
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="w-full"
                        alt="Phone image"
                    />
                </div>
                <div class="md:w-8/12 lg:w-5/12 lg:ml-20">
                    <form @submit.prevent="handleLogin">
                        <!-- Email input -->
                        <div class="mb-6">
                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                :placeholder="$t('login.email')"
                            />
                        </div>

                        <!-- Password input -->
                        <div class="mb-6">
                            <input
                                v-model="form.password"
                                type="password"
                                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                :placeholder="$t('login.password')"
                            />
                        </div>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light"
                        >
                            {{ processing ? $t('loading') : $t('login.login') }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import AuthResource from "../api/authResource";
import { mapActions } from "vuex";
import axios from "axios";

const resource = new AuthResource();

export default {
    name: 'Login',

    data() {
        return {
            form:{
                email:'',
                password:''
            },
            processing:false
        }
    },
    methods: {
        ...mapActions({
            setUser:'auth/setUser'
        }),

        handleLogin() {
            this.processing = true

            resource.login(this.form).then(resp => {
                if (resp.data.user && resp.data.token) {
                    this.setUser(resp.data)
                    axios.defaults.headers.common.Authorization = `Bearer ${resp.data.token}`
                    this.$router.push({ name: 'dashboard' })
                } else {
                    this.$helpers.errorMessage(resp)
                }
            })
            .catch(err => {
                this.$helpers.errorMessage(err)
            })
            .finally(() => {
                this.processing = false
            })
        },
    }
}
</script>
