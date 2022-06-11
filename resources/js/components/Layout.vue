<template>
    <div class="layout">
        <nav
            class="z-0 relative">
            <div class="relative z-10 shadow">
                <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                    <div class="relative flex items-center justify-between h-16">
                        <div class="flex items-center px-2 lg:px-0">
                            <div class="lg:block lg:ml-2">
                                <div v-if="user" class="flex">
                                    {{ $t('dashboard.hi') }}, {{ user.name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="lg:block lg:ml-2">
                                <div class="flex">
                                    <div class="mr-15">
                                        <language-switcher />
                                    </div>
                                    <router-link to="/logout"
                                                 class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-800 font-semibold hover:bg-blue-500 hover:text-white transition duration-150 ease-in-out cursor-pointer focus:outline-none focus:text-white focus:bg-gray-700 ">
                                        {{ $t('logout') }}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto my-10">
            <router-view />
        </div>
    </div>

</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "Layout",

    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    }
}
</script>
