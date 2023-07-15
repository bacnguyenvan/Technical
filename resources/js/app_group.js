import axios from 'axios';
import './bootstrap';

const form = document.getElementById('form-group');

const inputMessage = document.getElementById('input-message');

const listMessage = document.getElementById('list-message');

form.addEventListener('submit', function (event) {
    event.preventDefault();
    const userInput = inputMessage.value;

    axios.post('/group/chat', {
        message: userInput,
    })

    inputMessage.value = '';
})



// Group

const channel = Echo.join('private.chat.1'); // Echo.channel -> Echo.private

channel
.here((users) => {
    console.log("here");
})
.joining((user) => {
    addChatMessage(user.name, "has joined the room!")
})
.leaving((user) => {
    addChatMessage(user.name, "has left the room.", "grey")
})
.listen('.chat-msg', (event) => { // chat-msg: broadcastAs
    const message = event.message;

    addChatMessage(event.user.name, message);

});

function addChatMessage(name, message, color = "black") {
    var mesContent = '<div class="message">' +
            '<h4 class="mes-name">' + name + '</h4>' +
            '<div class="mes-content" style="color: ' + color + '">' + message +  '</div>' +
        '</div>';
    
    listMessage.innerHTML += mesContent;
}
