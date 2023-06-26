<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'content'];

    public static function getConversations($senderId, $receiverId)
    {
        return self::where(['sender_id' => $senderId, 'receiver_id' => $receiverId])
                    -> orWhere(function($q) use ($senderId, $receiverId){
                        $q->where(['sender_id' => $receiverId, 'receiver_id' => $senderId]);
                    })
                    -> get();
    }
}
