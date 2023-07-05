import axios from 'axios';
import './bootstrap';

const form = document.getElementById('form-group');

const inputMessage = document.getElementById('input-message');


form.addEventListener('submit', function (event) {
    event.preventDefault();
    const userInput = inputMessage.value;

    axios.post('/group/chat', {
        message: userInput,
    })

    inputMessage.value = '';
})



// Group

const channel = Echo.private('private.chat.1'); // Echo.channel -> Echo.private

channel.subscribed(() => {
    console.log('subscribed');
}).listen('.chat-msg', (event) => { // chat-msg: broadcastAs
    console.log("data: ", event);
});

