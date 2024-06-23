<?php

namespace App\Http\Controllers;

use App\Contracts\NotifyInterface;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
class HomeController extends Controller
{
    // case1: register all Class => __construct
    // private $notify;

    // public function __construct(NotifyInterface $notify)
    // {
    //     $this->notify = $notify;
    // }

    // case2: just register specific function

    public function index()
    {
        return view('home.index');
    }

    // case 1:
    // public function testOne()
    // {
    //     return $this->notify->send();
    //     dd("testOne");
    // }

    // case 2:
    public function testOne(NotifyInterface $notify)
    {
        return $notify->send();
        dd("testOne");
    }

    public function epsilon(Request $request)
    {
        if($request->isMethod('POST')){
            $orderUrl = 'https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi'; 
            $orderNumber = rand(0, 99999999);

            $st_code = [
                'normal'  => '10100-0000-00000-00010-00000-00000-00000',
                'card'    => '10000-0000-00000-00000-00000-00000-00000',
                'conveni' => '00100-0000-00000-00000-00000-00000-00000',
                'atobarai' => '00000-0000-00000-00010-00000-00000-00000',
            ];

            $prefList = [
                11 => '北海道',
                12 => '青森県'
            ];

            $memo1 = "試験用オーダー情報";
            $memo2 = "";

            $st = $request->st;
            $conveniCode = $request->conveni_code;
            $consigneePostal = $request->consignee_postal;

            $postData = [
                'version' => '2',
                'contract_code' => "74885520",
                'user_id' => $request->user_id,
                'user_name' => mb_convert_encoding( $request->user_name, 'UTF-8', 'auto'),
                'user_mail_add' => $request->user_mail_add,
                'item_code' => $request->item_code,
                'item_name' => mb_convert_encoding($request->item_name, 'UTF-8', 'auto'),
                'order_number' => $orderNumber,
                'st_code' => $st_code[$st],
                'mission_code' => $request->mission_code,
                'item_price' => $request->item_price,
                'process_code' => $request->process_code,
                'memo1' => $memo1,
                'memo2' => $memo2,
                'xml' => '1',
                'character_code' => 'UTF8'
            ];

            $options = [
                'timeout' => 20,
                'verify' => false, // equivalent to 'ssl_verify_peer' => false
            ];

            $consigneePref = $request->consignee_pref;
            $consigneeAddress = $request->consignee_address;

            if ($st == 'conveni' && $conveniCode != 0) {
                $postData['conveni_code'] = $conveniCode;
                $postData['user_tel'] = $request->user_tel;
                $postData['user_name_kana'] = mb_convert_encoding($request->user_name_kana, 'UTF-8', 'auto');
            } elseif (($st == 'normal' || $st == 'atobarai') && $consigneePostal) {
                $postData['delivery_code'] = 99;
                $postData['consignee_postal'] = $request->consignee_postal;
                $postData['consignee_name'] = $request->consignee_name;
                $postData['consignee_address'] = sprintf('%s%s', $prefList[$consigneePref], $consigneeAddress);
                $postData['consignee_tel'] = $request->consignee_tel;
                $postData['orderer_postal'] = $request->orderer_postal;
                $postData['orderer_name'] = $request->orderer_name;
                $postData['orderer_address'] = sprintf('%s%s', $prefList[$consigneePref], $consigneeAddress);
                $postData['orderer_tel'] = $request->orderer_tel;
            }

            $response = Http::withOptions($options)->asForm()->post($orderUrl, $postData);

            if ($response->successful()) {
                $resContent = str_replace('x-sjis-cp932', 'UTF-8', $response->body());
                try {
                    $xml = simplexml_load_string($resContent, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    $resArray = json_decode($json, true);

                    $isXmlError = false;
                    $xmlRedirectUrl = '';
                    $xmlErrorCd = '';
                    $xmlErrorMsg = '';
                    $xmlMemo1Msg = '';
                    $xmlMemo2Msg = '';
                    $result = '';
                    $transCode = '';

                    foreach ($resArray['result'] as $unsV) {
                        foreach ($unsV as $resultAtrKey => $resultAtrVal) {
                            switch ($resultAtrKey) {
                                case 'redirect':
                                    $xmlRedirectUrl = rawurldecode($resultAtrVal);
                                    break;
                                case 'err_code':
                                    $isXmlError = true;
                                    $xmlErrorCd = $resultAtrVal;
                                    break;
                                case 'err_detail':
                                    $xmlErrorMsg = mb_convert_encoding(urldecode($resultAtrVal), 'UTF-8', 'auto');
                                    break;
                                case 'memo1':
                                    $xmlMemo1Msg = mb_convert_encoding(urldecode($resultAtrVal), 'UTF-8', 'auto');
                                    break;
                                case 'memo2':
                                    $xmlMemo2Msg = mb_convert_encoding(urldecode($resultAtrVal), 'UTF-8', 'auto');
                                    break;
                                case 'result':
                                    $result = mb_convert_encoding(urldecode($resultAtrVal), 'UTF-8', 'auto');
                                    break;
                                case 'trans_code':
                                    $transCode = mb_convert_encoding(urldecode($resultAtrVal), 'UTF-8', 'auto');
                                    break;
                                default:
                                    break;
                            }
                        }
                    }

                    // Handle the parsed response data as needed.
                } catch (\Exception $e) {
                    Log::error('XML parsing error: ' . $e->getMessage());
                    // Handle the error, e.g., by returning an error message to the user.
                }
            } else {
                Log::error('HTTP error: ' . $response->status());
                Log::error('Error message: ' . $response->body());
                // Handle the HTTP error, e.g., by returning an error message to the user.
            }

            if ($isXmlError) {
                $err_msg = "エラー : " . $xmlErrorCd . $xmlErrorMsg;
                dd($err_msg);
            } else {
                if (!empty($xmlRedirectUrl)) {
                    header("Location: " . $xmlRedirectUrl);
                    exit(0);
                } elseif (!empty($transCode)) {
                    dd($transCode);
                    // header("Location: " . $confirm_url . "?trans_code=" . $trans_code);
                    exit();
                } else {
                    dd($resArray);
                    dd("error!!!");
                }
            }
        }

        return view('payment.epsilon');
    }

    public function videos()
    {
        return Video::all();
    }
}
