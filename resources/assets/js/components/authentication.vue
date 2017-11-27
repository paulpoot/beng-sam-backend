<template>
    <div>
        <b-btn v-b-modal.loginModal variant="primary">Login</b-btn>

        <!-- Modal Component -->
        <b-modal id="loginModal" title="Log in" ok-title="Log in" @ok="login">
            <b-form-input v-model="email"
                  type="email"
                  placeholder="Enter your email"></b-form-input>
            <b-form-input v-model="password"
                  type="password"
                  placeholder="Enter your password"></b-form-input>
        </b-modal>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';

    export default {
        props: {
            'id': { required: false },
            'link': { default: false },
        },
        data() {
            return {
                email: null,
                password: null,
            }
        },
        methods: {
            login: function() {
                var self = this;

                axios.post('/v1/auth/login', {
                    email: this.email,
                    password: this.password,
                })
                .then(function (response) {
                    var token = response.data.token;
                    self.$store.dispatch('login', token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            console.log('auth component mounted')
        }
    }
</script>