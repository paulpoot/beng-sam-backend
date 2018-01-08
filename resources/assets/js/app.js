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

import 'vue-awesome/icons'
import Icon from 'vue-awesome/components/Icon'
Vue.component('icon', Icon)

import axios from 'axios'
import config from '../../../config'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('main-navigation', require('./components/mainNavigation.vue'));
Vue.component('authentication', require('./components/authentication.vue'));
Vue.component('conversation-nav', require('./components/conversationNav.vue'));
Vue.component('chat-window', require('./components/chatWindow.vue'));

const store = new Vuex.Store({
    state: {
        isLoggedIn: localStorage.getItem('token'),
        activeConversation: localStorage.getItem('activeConversation')
    },
    getters: {
        isLoggedIn: state => {
            return state.isLoggedIn;
        },
        activeConversation: state => {
            return state.activeConversation;
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
        },
        ['SELECT_CONVERSATION'](state, conversationId) {
            state.activeConversation = conversationId;
        }
    },
    actions: {
        login({state, commit, rootState}, token) {
            localStorage.setItem("token", token);
            commit("LOGIN_SUCCESS");
        },
        logout({commit}) {
            localStorage.removeItem("token");
            commit("LOGOUT");
        },
        selectConversation({state, commit, rootState}, conversationId) {
            localStorage.setItem("activeConversation", conversationId);
            commit("SELECT_CONVERSATION", conversationId);
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
            var self = this;
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.isLoggedIn}`;                   

            axios.get(config.API_URL + 'auth/refresh')
            .then(function (response) {
                var token = response.data.token;
                self.$store.dispatch('login', token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            })
            .catch(function (error) {
                console.log('didnt get convs');
            });
        }
    }
});
