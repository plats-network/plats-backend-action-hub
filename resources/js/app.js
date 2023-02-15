window.Vue = require('vue').default;
window.axios = require('axios');
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var ES6Promise = require("es6-promise");
ES6Promise.polyfill();
import ElementUI from 'element-ui';
import { ElementTiptapPlugin } from 'element-tiptap';
import locale from 'element-ui/lib/locale/lang/vi'
// import DisableAutocomplete from 'vue-disable-autocomplete';
Vue.use(ElementUI, { locale })
Vue.use(ElementTiptapPlugin, { /* plugin options */ });
Vue.component('task', require('./components/task/Index.vue').default);
Vue.component('task-edit', require('./components/task/Edit.vue').default);
Vue.component('task-create', require('./components/task/Create.vue').default);
Vue.component('reward', require('./components/reward/index.vue').default);
Vue.component('group', require('./components/group/index.vue').default);
Vue.component('user', require('./components/user/index.vue').default);




// Vue.use(DisableAutocomplete);
const app = new Vue({
    el: '#app',
});
