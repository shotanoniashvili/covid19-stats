<template>
    <div class="overflow-hidden">
        <div class="actions mb-5">

            <div class="font-semibold mb-5">{{ $t('table.total-rows') }}: {{ total }}</div>
            <div class="flex justify-between">
                <button  @click="handleReload" class="inline-block px-6 py-2.5 bg-blue-600 text-white
                             font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700
                              hover:shadow-lg focus:bg-blue-700
                              focus:shadow-lg focus:outline-none
                              focus:ring-0 active:bg-blue-800 active:shadow-lg
                               transition duration-150 ease-in-out">{{ $t('table.reload') }}</button>
                <input
                    @input="handleSearch"
                    v-model="keyword"
                    type="text"
                    class="form-control
                                    block
                                    w-120
                                    px-3
                                    py-1.5
                                    text-base
                                    font-normal
                                    text-gray-700
                                    bg-white bg-clip-padding
                                    border border-solid border-gray-300
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    :placeholder="$t('table.keyword')"
                />
            </div>
        </div>
        <table class="border min-w-full text-center">
            <thead class="border-b bg-white">
            <tr>
                <th v-for="col of columns"
                    :key="col.col"
                    scope="col"
                    class="text-sm font-medium text-gray-900 px-6 py-2 position-relative">
                    {{ col.label }}

                    <div v-if="col.sortable" class="sort">
                        <span @click="handleSort(col.col)"
                              :class="['sort-icon',
                              { active: order.col === col.col },
                              { asc: order.col === col.col && order.by === 'asc' },
                              { desc: order.col === col.col && order.by === 'desc' } ]"></span>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            <template v-if="loading">
                <tr class="bg-white border-b hover:bg-gray-100">
                    <td :colspan="columns.length" class="py-20 text-center">
                        {{ $t('table.loading') }}
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr v-for="row of filteredRows" class="bg-white border-b hover:bg-gray-100">
                    <td v-for="col of columns" class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                        {{ rowValue(row, col.col) }}
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import _ from 'lodash'
export default {
    name: 'DataTable',

    props: [ 'dataProvider', 'columns' ],

    computed: {
        total() {
            return this.filteredRows.length
        }
    },

    data() {
        return {
            rows: [],
            loading: false,
            keyword: '',
            order: {
                col: '',
                by: ''
            },
            filteredRows: []
        }
    },

    mounted() {
        this.loadData()
    },

    methods: {
        rowValue(row, col) {
            return _.get(row, col)
        },

        handleReload() {
            this.loadData()
        },

        handleSearch() {
            this.filteredRows = this.rows

            if (this.keyword) {
                this.filteredRows = this.filteredRows.filter(o => {
                    for (const col of this.columns) {
                        const val = _.get(o, col.col).toString().toLowerCase()

                        if(val.indexOf(this.keyword.toLowerCase()) > -1)
                            return true
                    }
                })
                this.order = { col: '', by: '' }
            }
        },

        handleSort(col) {
            if (this.order.col === col && this.order.by === 'asc') {
                this.order = {
                    col: col,
                    by: 'desc'
                }
                this.filteredRows = _.sortBy(this.filteredRows, [col]).reverse()
                return;
            }

            if (this.order.col === col && this.order.by === 'desc') {
                this.order = {
                    col: '',
                    by: ''
                }
                this.filteredRows = _.sortBy(this.filteredRows, ['code'])
                return;
            }

            if (this.order.col !== col) {
                this.order = {
                    col: col,
                    by: 'asc'
                }
                this.filteredRows = _.sortBy(this.filteredRows, [col])
            }
        },

        loadData() {
            this.loading = true
            this.dataProvider()
                .then(resp => {
                    this.rows = resp.data.data
                    this.keyword = ''
                    this.sort = null
                    this.filteredRows = this.rows
                })
                .catch(err => {
                    this.$helpers.errorMessage(err)
                })
                .finally(() => {
                    this.loading = false
                })
        },
    }
}
</script>

<style scoped>
    .sort {
        position: absolute;
        right: 8px;
        top: 8px;
    }

    .sort-icon {
        padding: 4px;
        cursor: pointer;
    }

    .sort-icon.active {
        color: #3fc3ee;
    }

    .sort-icon::after {
        content: '⇅';
    }

    .sort-icon.active.asc::after {
        content: '↾';
    }

    .sort-icon.active.desc::after {
        content: '⇂';
    }
</style>
