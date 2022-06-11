import Vue from "vue";
import i18n from './i18n';

function displayMessage(html,
                        title = '',
                        icon = '') {
    Vue.swal({
        title,
        html,
        icon
    })
}

function validationMessages(errors) {
    const messages = [];
    for(let key in errors) {
        for(let err of errors[key])
            messages.push(i18n.t('errors.'+err));
    }

    displayMessage(messages.join('<br />'), '', 'error')
}

export function successMessage(message) {
    displayMessage(message, '', 'success')
}

export function errorMessage(error) {
    console.log(error)
    if (error?.response?.status === 422 && error?.response?.data?.errors) {
        validationMessages(error?.response?.data?.errors)
        return;
    }

    if (error?.response?.data?.message) {
        displayMessage(error?.response?.data?.message, '', 'error')
        return;
    }

    if (error?.data?.message) {
        displayMessage(error?.data?.message, '', 'error')
        return;
    }

    displayMessage(i18n.t('app.error'), '', 'error')
}
