// Import dependencies and bootstrap setup
import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';

// Import Laravel Echo and Pusher
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
});

window.Echo.channel('public-channel')
    .listen('.event-name', (e) => {
        console.log('Received:', e);
    });

    window.Echo.channel('game-channel')
    .listen('.player-moved', (data) => {
        console.log('Received broadcast:', data);
    });
    
// Create and mount the Vue app
createApp(App).use(store).use(router).mount('#app');

