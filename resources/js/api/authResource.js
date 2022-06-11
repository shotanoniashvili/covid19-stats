export default class AuthResource {
    login({ email, password }) {
        return axios.post('/api/login', { email, password });
    }

    user() {
        return axios.get('/api/user');
    }

    logout() {
        return axios.post('/api/logout')
    }
}
