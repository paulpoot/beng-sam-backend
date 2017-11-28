<template>
    <div>
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul class="nav nav-pills flex-column">
                <li v-for="conversation in conversations" class="nav-item" @click="openConversation(conversation._id)">
                    <a :class="(conversationId === conversation._id) ? 'nav-link active' : 'nav-link inactive'" href="#">{{ conversation.name }} <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';
    import config from '../../../../config';

    export default {
        data() {
            return {
                conversations: null
            }
        },
        computed: {
            ...Vuex.mapGetters({
                conversationId: 'activeConversation'
            })
        },
        methods: {
            ...Vuex.mapActions(['selectConversation']),
            loadConversations: function() {
                var self = this;

                axios.get(config.API_URL + 'admin/conversation')
                .then(function (response) {
                    console.log(response);
                    self.conversations = response.data;
                })
                .catch(function (error) {
                    console.log('didnt get convs');
                });
            },
            openConversation: function(conversationId) {
                this.$store.dispatch('selectConversation', conversationId);
            }
        },
        mounted() {
            this.loadConversations();

            setInterval(function () {
                this.loadConversations();
            }.bind(this), 10000); 
        }
    }
</script>