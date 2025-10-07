import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// import _ from 'lodash';
// window._ = _;

import $ from 'jquery';
window.$ = window.jQuery = $;