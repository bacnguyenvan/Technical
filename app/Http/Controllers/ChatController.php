<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

use App\Models\User;
use App\Events\HelloEvent;
use App\Events\MessageSent;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $lists = User::where('id', '!=', auth()->user()->id)->get();
        $conversations = [];
        
        if(count($lists)) {
            $userFirst = $lists[0];
            $senderId = auth()->user()->id;
            $receiverId = $userFirst->id;

            $conversations = Message::getConversations($senderId, $receiverId);
        }

        return view('chat', compact('lists', 'conversations'));
    }

    public function chat(Request $request)
    {
        $message = $request->message;
        $senderId = $request->senderId;
        $receiverId = $request->receiverId;

        $data = [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $message
        ];

        $messageData = Message::create($data);

        event(new HelloEvent($senderId, $receiverId, $message));

        return $message;
    }


    public function sendMessage(Request $request)
    {
        $message = Chat::create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

    public function getMessages()
    {
        return Chat::with('user')->get();
    }


}
