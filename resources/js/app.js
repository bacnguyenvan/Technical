import axios from 'axios';
import './bootstrap';

const form = document.getElementById('form');

const inputMessage = document.getElementById('input-message');


form.addEventListener('submit', function (event) {
    event.preventDefault();
    const userInput = inputMessage.value;

    axios.post('/chat-message', {
        message: userInput,
        senderId: $('#s_id').val(),
        receiverId: $('#r_id').val(),
    })

    inputMessage.value = '';
})

const channel = Echo.channel('public.chat.1');

channel.subscribed(() => {
    console.log('subscribed');
}).listen('.chat-msg', (event) => { // chat-msg: broadcastAs
    console.log(event);

    const msg = event.message;
    const senderId = event.sender_id;
    const receiverId = event.reicever_id;

    var sId = $('#s_id').val();
    var rId = $('#r_id').val();
    var me = sId == senderId;

    var li = '<li class="clearfix">' +
        '<div class="message-data ' + (me ? 'text-right' : 'text-left') + '">' +
        '<span class="message-data-time">2023-06-26 21:31:45</span>';

    if (me) {
        li += '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">';
    }

    li += '</div>' +
        '<div class="message ' + (me ? 'other-message float-right' : 'my-message') + '"> ' + msg + ' </div></li>';

    console.log(li);

    if( ((sId == senderId) && (rId == receiverId)) || ((rId == senderId) && (sId == receiverId)) ) {
        $("#content-converstation").append(li);
    }
})
