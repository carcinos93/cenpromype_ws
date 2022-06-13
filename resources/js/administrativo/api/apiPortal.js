import axios from 'axios';
const apiLocal = axios.create({
    baseURL: window['url_api'],
});

export default apiLocal;