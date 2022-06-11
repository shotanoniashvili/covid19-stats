export default class CountryResource {
    countries() {
        return axios.get('/api/countries');
    }

    country(countryId) {
        return axios.get(`/api/countries/${countryId}`);
    }
}
