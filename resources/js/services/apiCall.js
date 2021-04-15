import axios from "axios";

const apiCall = {
    init(baseURL) {
        axios.defaults.baseURL = baseURL;
    },

    get(resource, params = {}) {
        return axios.get(resource, { params });
    },

    post(resource, params, config) {
        return axios.post(resource, params, config);
    },

    delete(resource, params) {
        return axios.delete(resource, params);
    }
};

export default apiCall;
