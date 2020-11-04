<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Select a contact' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
import MessageComposer from './MessageComposer';
import MessagesFeed from './MessagesFeed';

export default { 
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Array,
            default: []
        }
    },
    methods: {
        sendMessage(text) {
            console.log(text)
        }
    },
   
    components: {MessagesFeed, MessageComposer}
}
</script>
