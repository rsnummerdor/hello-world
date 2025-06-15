import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Button from 'primevue/button';
import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primeicons/primeicons.css';

const app = createApp({});
app.use(PrimeVue);
app.component('Button', Button);
app.mount('#app');
