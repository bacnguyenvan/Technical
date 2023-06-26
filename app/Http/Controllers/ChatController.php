<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

use App\Models\User;

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
}
