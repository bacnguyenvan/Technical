import axios from 'axios';
import './bootstrap';
import { message } from 'laravel-mix/src/Log';

const form = document.getElementById('form');

const inputMessage = document.getElementById('input-message');

const listMessage = document.getElementById('list-message');



form.addEventListener('submit', function(event) {
    event.preventDefault();
    const userInput = inputMessage.value;

    axios.post('/chat-message', {
        message: userInput
    })
})

const channel = Echo.channel('public.chat.1');

channel.subscribed(() => {
    console.log('subscribed');
}).listen('.chat-msg', (event) => {
    console.log(event);

    const msg = event.message;
    const li = document.createElement('li');

    li.textContent = msg;

    listMessage.append(li);
})
