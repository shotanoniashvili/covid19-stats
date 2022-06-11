<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <data-table :columns="columns" :data-provider="dataProvider" />
            </div>
        </div>
    </div>
</template>

<script>
import CountryResource from "../api/countryResource";
import DataTable from "../components/DataTable";

const resource = new CountryResource()

export default {
    name: "Dashboard",
    components: {DataTable},
    data() {
        return {
            columns: [
                { col: 'code', label: this.$t('dashboard.country-code'), sortable: false },
                { col: 'name', label: this.$t('dashboard.country-name'), sortable: false },
                { col: 'latest_statistics.confirmed', label: this.$t('dashboard.confirmed'), sortable: true },
                { col: 'latest_statistics.recovered', label: this.$t('dashboard.recovered'), sortable: true },
                { col: 'latest_statistics.death', label: this.$t('dashboard.death'), sortable: true },
            ],
            dataProvider: resource.countries
        }
    }
}
</script>
