import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from "axios";
import _ from "lodash";

window.Pusher = Pusher;
window.axios = axios;
window._ = _;

window.Echo = new Echo({
    broadcaster:       'reverb',
    key:               import.meta.env.VITE_REVERB_APP_KEY,
    wsHost:            import.meta.env.VITE_REVERB_HOST,
    wsPort:            import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort:           import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS:          (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
