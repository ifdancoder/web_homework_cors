import axios from 'axios';
import { ref } from 'vue';

const apiClient = axios.create({
    baseURL: 'http://localhost:80/api',
    headers: {
        'Content-Type': 'application/json',
    },
    withCredentials: true,
});

export default apiClient;