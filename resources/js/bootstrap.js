import _ from 'lodash';
window._ = _;

// import popper from 'popper.js';
// import jquery from 'jquery';
//
// try {
//     window.Popper = popper;
//     window.$ = jquery;
// } catch (e) {
//     console.error(e);
// }

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
