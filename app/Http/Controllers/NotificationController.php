<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NotificationController extends Controller
{
    public function sendTestNotification(Request $request, ?array $fcm_tokens = null)
    {
        $notification = $request->only(['title', 'body', 'area_id', 'route_id', 'news_id']);

        $fcm_tokens = $fcm_tokens ?? $this->getConfigFCMTokens();
        $messages = [];
        foreach ($fcm_tokens as $token) {
            if (empty($token)) {
                continue;
            }

            $messages[] = [
                'token' => $token,
                'notification' => [
                    'title' => $notification['title'],
                    'body' => $notification['body']??'',
                ],
                'data' => [
                    '_mem_noti_id' => $token,
                    'area_id' => $notification['area_id'] ?? null,
                    'route_id' => $notification['route_id'] ?? null,
                    'news_id' => $notification['news_id'] ?? null,
                ]
            ];
        }

        if (empty($messages)) {
            return ['No message to sent.'];
        }

        return $this->sendMessages($messages);
    }

    protected function getConfigFCMTokens()
    {
        $tokens = config('firebase.push_notification.send_test_fcm_tokens');
        return explode(',', $tokens);
    }

    protected function sendMessages(array $message)
    {
        $report = Firebase::messaging()->sendAll($message);
        $success = [];
        $failure = [];

        foreach ($report->getItems() as $item) {
            // dd($item->message());
            $_mem_noti_id = $item->message()
            ->jsonSerialize()['data']['_mem_noti_id'];

            if ($item->isSuccess()) {
                $success[$_mem_noti_id] = $_mem_noti_id;
            } else {
                $failure[$_mem_noti_id] = $_mem_noti_id;
            }
        }

        return [
            'success' => $success,
            'failure' => $failure,
        ];
    }


    public function getFCMToken()
    {
        return view('firebase.fcm_token');
    }
}
