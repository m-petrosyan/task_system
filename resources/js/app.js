import {createApp} from 'vue';
import {createPinia} from 'pinia';
import Main from './App.vue';
import router from "./router";
import '../css/app.css';


const app = createApp(Main);

app.use(createPinia())
    .use(router)
    .mount('#app');
