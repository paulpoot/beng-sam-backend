<template>
    <div>
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar conversation-nav">
            <ul class="nav nav-pills flex-column">
                <li v-for="conversation in conversations" class="nav-item">
                    <div :class="(conversationId === conversation._id) ? 'nav-link active' : 'nav-link inactive'" href="#">
                        <a href="#" @click="openConversation(conversation._id)">
                            {{ conversation.name }} <span class="sr-only">(current)</span>
                        </a>
                        
                        <div class="delete" @click="openDeleteModal(conversation)">
                            <icon name="times"></icon>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <b-modal v-if="conversationToDelete" id="deleteConversation" title="Delete conversation?" v-model="showDeleteModal">
            <p>Are you sure you want to delete this conversation with {{ conversationToDelete.name }}?</p>
            
            <div slot="modal-footer">
                <b-btn size="md" class="float-right ml-2" @click="showDeleteModal = false; conversationToDelete = null">
                    Close
                </b-btn>
                <b-btn size="md" class="float-right" variant="danger" @click="deleteConversation()">
                    Delete
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate';
    import axios from 'axios';
    import config from '../../../../config';

    export default {
        data() {
            return {
                conversations: null,
                showDeleteModal: false,
                conversationToDelete: null,
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
                    self.conversations = response.data;
                })
                .catch(function (error) {});
            },
            openConversation: function(conversationId) {
                this.$store.dispatch('selectConversation', conversationId);
            },
            openDeleteModal: function(conversation) {
                this.showDeleteModal = true;
                this.conversationToDelete = conversation;
            },
            deleteConversation: function() {
                var self = this;

                axios.delete(config.API_URL + 'admin/conversation/' + this.conversationToDelete._id)
                .then(function (response) {
                    self.showDeleteModal = false;
                    self.conversationToDelete = null;
                    self.loadConversations();
                })
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