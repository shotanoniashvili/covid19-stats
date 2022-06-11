import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import localization from './localization'

Vue.use(Vuex)

export default new Vuex.Store({
    modules:{
        auth, localization
    }
})
