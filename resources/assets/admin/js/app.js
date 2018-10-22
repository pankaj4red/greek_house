
/** Dependencies */
require('./bootstrap');
require('./vendor/cssua.min');
require('./vendor/jquery-ui.min');
require('lodash');
require('./vendor/jquery.ns-autogrow.min');
require('./vendor/metisMenu.min');
require('./vendor/Chart.min');
require('./vendor/jquery.dataTables');
require('./vendor/dataTables.bootstrap4');
require('./vendor/sb-admin.min');

/** Vue */
window.Vue = require('vue');
window.imagesLoaded = require('vue-images-loaded');
import axios from 'axios'
Vue.prototype.$http = axios;

/** Custom jQuery Code */
require('./custom/load_script');
require('./custom/datepicker');
require('./custom/filepicker');

/** Custom Vue Code */


