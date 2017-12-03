<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">Sam</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Chats <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form class="form-inline mt-2 mt-md-0">
                    <authentication v-if="!isLoggedIn"></authentication>
                    <b-btn v-if="isLoggedIn" @click="logout" variant="primary">Logout</b-btn>
                </form>
            </div>
        </nav>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';

    export default {
        methods: {
            ...Vuex.mapActions(['logout'])
        },
        computed: {
            ...Vuex.mapGetters(['isLoggedIn'])
        },
        mounted() {
            console.log('auth component mounted')
        }
    }
</script>