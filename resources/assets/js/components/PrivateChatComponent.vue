<template>
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card card-default">
                    <div class="card-header">The Fine Chat App</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="10" readonly>{{ messages.join("\n") }}</textarea>
                                <hr>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="textMessage"
                                    @keyup.enter="sendMessage"
                                    @keydown="actionUser">
                                <span class="badge badge-info small" v-if="isActive">
                                    {{ isActive.name }} typing ...
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <ul>
                                    <li v-for="user in activeUsers">{{ user }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["room", "user"],
        data() {
            return {
                messages: [],
                textMessage: '',
                isActive: false,
                typingTimer: false,
                activeUsers: []
            }
        },
        computed: {
            channel() {
                return window.Echo.join('room.' + this.room.id);
            }
        },
        mounted() {
            this.channel
                .here((users) => {
                    this.activeUsers = users
                })
                .joining((user) => {
                    this.activeUsers.push(user)
                })
                .leaving((user) => {
                    this.activeUsers.splice(this.activeUsers.indexOf(user), 1)
                })
                .listen('PrivateChat', ({data}) => {
                    this.messages.push(data.body);
                    this.isActive = false;
                })
                .listenForWhisper('typing', e => {
                    this.isActive = e;

                    if (this.typingTimer) clearTimeout(this.typingTimer);

                    this.typingTimer = setTimeout(() => {
                        this.isActive = false;
                    }, 2000);
                });
        },
        methods: {
            sendMessage() {

                if (!this.textMessage.length) {
                    return true;
                }

                axios.post('/chat/send-message', {
                    body: this.textMessage,
                    room_id: this.room.id
                });

                this.messages.push(this.textMessage);

                this.textMessage = '';
            },

            actionUser() {
                this.channel
                    .whisper('typing', {
                        name: this.user.name
                    });
            }
        }
    }
</script>
