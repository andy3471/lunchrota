import _ from 'lodash';
window._ = _;

import jquery from 'jquery';
window.$ = window.jQuery = jquery;

import bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
