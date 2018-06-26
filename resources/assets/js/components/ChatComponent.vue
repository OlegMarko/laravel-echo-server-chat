<template>
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card card-default">
                    <div class="card-header">The Fine Chat App</div>

                    <div class="card-body">
                        <textarea class="form-control" rows="10" readonly>{{ messages.join("\n") }}</textarea>
                        <hr>
                        <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                textMessage: ''
            }
        },
        mounted() {
            console.log('Chat Component mounted.');

            window.Echo
                .channel('chat')
                .listen('Message', ({message}) => {
                    this.messages.push(message.body)
                });
        },
        methods: {
            sendMessage() {

                if (!this.textMessage.length) {
                    return true;
                }

                axios.post('/chat/send-message', {
                    body: this.textMessage
                });

                this.messages.push(this.textMessage);

                this.textMessage = '';
            }
        }
    }
</script>
