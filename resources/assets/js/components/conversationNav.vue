<template>
    <div>
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul class="nav nav-pills flex-column">
                <li v-for="conversation in conversations" class="nav-item">
                    <a class="nav-link active" href="#">{{ conversation.name }} <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';

    export default {
        data() {
            return {
                conversations: null
            }
        },
        methods: {
            loadConversations: function() {
                var self = this;

                axios.get('/v1/admin/conversation')
                .then(function (response) {
                    console.log(response);
                    self.conversations = response.data;
                })
                .catch(function (error) {
                    console.log('didnt get convs');
                });
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