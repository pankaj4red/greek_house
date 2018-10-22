
/** Dependencies */
require('./bootstrap');
require('./vendor/cssua.min');
require('./vendor/jquery-ui.min');
require('jquery-colorbox');
require('select2');
require('owl.carousel');
require('lodash');
require('./vendor/jquery.ns-autogrow.min');

/** Vue */
window.Vue = require('vue');
window.imagesLoaded = require('vue-images-loaded');
import axios from 'axios'
Vue.prototype.$http = axios;

/** Custom jQuery Code */
require('./custom/image_loading');
require('./custom/load_script');

/** Custom Vue Code */
require('./custom/wizard');
require('./custom/design_gallery_tags');
require('./custom/design_gallery');
require('./custom/checkout');
require('./custom/checkout_add_to_cart');

/** Custom jQuery Code */
require('./custom/owl_carousel_custom');
require('./custom/modal');
require('./custom/modal_ajax');
require('./custom/autogrow');
require('./custom/filepicker');
require('./custom/datepicker');
require('./custom/copy_clipboard');
require('./custom/group');
require('./custom/file_upload');
require('./custom/simple_confirm');
require('./custom/toggle_display');
require('./custom/color_pms_list');
require('./custom/autocomplete');
require('./custom/cart');
require('./custom/quantity_counter');
require('./custom/number_format');
require('./custom/functions');

