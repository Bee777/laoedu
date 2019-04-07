import Vue from 'vue';
import App from './vue/AppGeneral.vue';
import store from '@store/vuexGeneral';
import VueRouter from 'vue-router';
import routes from '@route/routesGeneral';
import VueCarousel from 'vue-carousel';

/**
 * @Component load
 */
import GeneralInput from '@cus-com/GeneralInput.vue';
import PostsSearchForm from '@com/General/Partial/PostsSearchForm.vue'
//
// const ToolTip = () => import('@cus-com/ToolTip.vue').then(a => a.default);

Vue.component('PostsSearchForm', PostsSearchForm);
Vue.component('GeneralInput', GeneralInput);
// Vue.component('ToolTip', ToolTip);
/**
 * @Component load
 */

Vue.use(VueCarousel);
Vue.use(VueRouter);
export const router = new VueRouter({
    mode: 'history',
    routes
});
/**
 * @Route guard
 */
Vue.prototype.initRouter(router, store).StartRouteGuard();
/**
 *
 * @Route guard
 */
Vue.prototype.$context_name = "app_general";
Vue.prototype.$settings = settings;
Vue.prototype.Route = Vue.prototype.initRouter(router, store).Route;
Vue.prototype.$utils.onWindowNewTap((info) => {
    store.commit('setWindowState', {WindowState: info});
});

export const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});
