<template>
    <div class="flex justify-between">

        <template v-if="loading">
            <div class="w-full" v-for="i in 3">
                <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm w-full">
                    <h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">{{ $t('loading') }}</h5>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm w-full">
                <h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">{{ $t('dashboard.confirmed') }}</h5>
                <p class="text-gray-700 text-base mb-4">
                    {{ summaryData.confirmed }}
                </p>
            </div>
            <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm w-full">
                <h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">{{ $t('dashboard.recovered') }}</h5>
                <p class="text-gray-700 text-base mb-4">
                    {{ summaryData.recovered }}
                </p>
            </div>
            <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm w-full">
                <h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">{{ $t('dashboard.death') }}</h5>
                <p class="text-gray-700 text-base mb-4">
                    {{ summaryData.death }}
                </p>
            </div>
        </template>
    </div>
</template>

<script>
import CountryResource from "../api/countryResource";

const resource = new CountryResource()

export default {
    name: "SummaryData",

    data() {
        return {
            summaryData: {
                confirmed: '',
                recovered: '',
                death: ''
            },
            loading: false
        }
    },

    mounted() {
        this.loadSummary()
    },

    methods: {
        loadSummary() {
            this.loading = true
            resource.summary()
            .then(resp => {
                this.summaryData = resp.data.data
            })
            .catch(err => {
                this.$helpers.errorMessage(err)
            })
            .finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
