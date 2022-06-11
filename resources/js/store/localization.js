import i18n from '../i18n';
import axios from 'axios';

export default {
    namespaced: true,

    state: {
        locale: 'ka'
    },

    getters: {
        locale: () => localStorage.getItem('locale') ? localStorage.getItem('locale') : 'ka',
    },

    actions: {
        setLocale({ state }, locale) {
            i18n.locale = locale;
            state.locale = locale;
            localStorage.setItem('locale', locale);
            axios.defaults.headers.common['Content-Language'] = locale;
        },
    },
};
