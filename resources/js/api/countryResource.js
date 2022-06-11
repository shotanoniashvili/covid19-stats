export default class CountryResource {
    countries() {
        return axios.get('/api/countries');
    }

    summary() {
        return axios.get(`/api/summary`);
    }
}
