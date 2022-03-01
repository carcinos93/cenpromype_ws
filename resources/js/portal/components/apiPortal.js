import axios from 'axios';
const apiPortal = axios.create({
    baseURL: window['url_api'],
});

export default apiPortal;