/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('main-navigation', require('./components/mainNavigation.vue'));
Vue.component('authentication', require('./components/authentication.vue'));
Vue.component('conversation-nav', require('./components/conversationNav.vue'));


const store = new Vuex.Store({
  state: {
    isLoggedIn: localStorage.getItem('token')
  },
  getters: {
    isLoggedIn: state => {
      return state.isLoggedIn;
    }
  },
  mutations: {
    ["LOGIN"](state) {
      state.pending = true;
    },
    ["LOGIN_SUCCESS"](state) {
      state.isLoggedIn = true;
      state.pending = false;
    },
    ["LOGOUT"](state) {
      state.isLoggedIn = false;
    }
  },
  actions: {
    login({
      state,
      commit,
      rootState
    }, token) {
      localStorage.setItem("token", token);
      commit("LOGIN_SUCCESS");
    },
    logout({
      commit
    }) {
      localStorage.removeItem("token");
      commit("LOGOUT");
    }
  },
})

const app = new Vue({
    el: '#app',
    data: {
      baseUrl: document.head.querySelector('meta[name="base-url"]').content
    },
    store,
    computed: {
      ...Vuex.mapGetters(['isLoggedIn'])
    },
    created() {
      if(this.isLoggedIn) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.isLoggedIn}`;        
      }
    }
});
