<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function getActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }

    public function index()
    {
        dd("oke");
    }

    public function sendMessage(Request $request)
    {
        if($request->isMethod('POST')) {
            $request->validate([
                'content' => 'required',
            ]);
     
            $text = "A new contact us query\n"
                . "<b>Content: </b>\n"
                . "$request->content\n";
                
     
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.mybot.chat_id'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

            return redirect()->back()->with('msg', 'send success');
        }
        
        return view('contact');
    }

    public function checkServer()
    {
        try {
            DB::connection()->getPdo();
            echo "connect server success";
        } catch (\Exception $e) {
            $text = "<b>Connect DB fail.</b>\n<b>Error: </b>" . $e -> getMessage();

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.mybot.chat_id'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

            echo $text;
        }
    }
}
