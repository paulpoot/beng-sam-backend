<template>
    <div class="chat-window container" v-if="conversation">
        <div class="chat-history" ref="chatHistory">
            <div v-for="message in conversation.messages" :class="'row message-wrapper-' + message.user_id">
                <div class="chat-message">
                    <div class="chat-message-content">
                        <img :src="message.image" v-if="message.image">
                        <br v-if="message.image" />
                        {{ message.content }}
                        <br />
                        <div class="chat-message-footer">
                            <span class="chat-message-time">{{ message.created_at }}</span>
                            <div class="delete" @click="deleteMessage(message)">
                                <icon name="times"></icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <b-input-group class="chat-input">
            <b-input-group-addon @click="loadConversation">
                Sam
            </b-input-group-addon>

            <!-- Main form input -->
            <b-form-input v-model="content"></b-form-input>

            <!-- Attach Right button Group via slot -->
            <b-input-group-button slot="right">
            <b-dropdown :text="type" variant="success" right>
                <b-dropdown-item @click="type = 'standard'">Standard</b-dropdown-item>
                <b-dropdown-item @click="type = 'link'">Link</b-dropdown-item>
            </b-dropdown>
            <b-btn variant="primary" @click="sendReply">Send</b-btn>
            </b-input-group-button>

        </b-input-group>

    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';
    import config from '../../../../config';

    export default {
        computed: {
            ...Vuex.mapGetters({
                conversationId: 'activeConversation'
            })
        },
        data() {
            return {
                conversation: null,
                content: null,
                type: 'standard',
                refreshInterval: 5000,
                urlRegex: /(?:https?|ftp):\/\/[\n\S]+/g,
            }
        },
        methods: {
            loadConversation: function() {
                var self = this;

                axios.get(config.API_URL + 'admin/conversation/' + this.conversationId)
                .then(function (response) {
                    self.conversation = response.data;
                    self.conversation.messages.forEach(function(item, index) {
                        if(item.type == 'link') {
                            if(item.content.indexOf('https://www.youtube.com/watch?v=') !== -1) {
                                item.link = item.content.match(self.urlRegex)[0];
                                var videoId = item.link.split('v=')[1];
                                item.image = 'https://img.youtube.com/vi/' + videoId + '/0.jpg';
                            }
                        }
                    });
                })
                .catch(function (error) {});
            },
            sendReply: function() {
                var self = this;
             
                if(this.content) {
                    axios.post(config.API_URL + 'admin/message', {
                        conversation_id: this.conversationId,
                        content: this.content,
                        type: this.type
                    })
                    .then(function (response) {
                        self.loadConversation();
                        self.content = '';
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            deleteMessage: function(message) {
                var self = this;

                axios.delete(config.API_URL + 'admin/message/' + message._id)
                .then(function (response) {
                    self.loadConversation();
                })
            }
        },
        watch: {
            conversationId: function() {
                this.loadConversation();
                setTimeout(function() {
                    this.$refs.chatHistory.scrollTop = this.$refs.chatHistory.scrollHeight - this.$refs.chatHistory.clientHeight;
                }.bind(this), 750);            
            }
        },
        mounted() {
            this.loadConversation();
            
            setTimeout(function() {
                this.$refs.chatHistory.scrollTop = this.$refs.chatHistory.scrollHeight - this.$refs.chatHistory.clientHeight;
            }.bind(this), 1000);

            this.refreshTimer = setInterval(function () {
                this.loadConversation();
            }.bind(this), this.refreshInterval); 
        }
    }
</script>