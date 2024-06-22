
// import { createApp } from 'vue';
// import './bootstrap';

// const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

// app.mount('#app');


import { createApp } from 'vue';
import router from './router';
import './bootstrap';

// import App from './App.vue';

createApp()
    .use(router)
    .mount('#app');



// import Vue from 'vue';
// import routes from './router/index'
// import './bootstrap';

// const app=new Vue({
//     el:'#app'
// });


