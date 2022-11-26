window._ = import('lodash');

import '../css/app.css';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import jQuery from 'jquery';
try {
    window.Popper = import('popper.js').default;
    window.$ = jQuery;
     window.jQuery = jQuery;

    import('bootstrap');
    
} catch (e) {
}


import DataTable from 'datatables.net-bs4';

window.DataTable = DataTable;



// import instascan from 'instascan';
// window.dataTableSelect = import('datatables.net-select-bs4');
// import 'jquery-datatables-checkboxes';

// import'datatables.net-select';
// import DataSelect from 'jquery-datatables-checkboxes';



// window.DataSelect = DataSelect;



DataTable(window,$);









/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = import('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
