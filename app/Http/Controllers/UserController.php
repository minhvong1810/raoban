<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AppHelpers;
use App\User;
use App\MessageSample;
use App\Events\RegisterAccount;
use App\ClassifiedAds;

class UserController extends Controller
{
    public function index(Request $request)
    {

    }

    /**
     * Store User data through Telcos
     *
     * @param Request $request
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        $urlQueryString = $request->query();
        $registerFailMessage = MessageSample::where('name', 'register_fail')->first();

        if($urlQueryString['Command_Code'] === 'TTV'){

            $phoneNumber = str_replace('84', '0', $urlQueryString['User_ID']);
            $message = substr($urlQueryString['Message'], 3);

            $user = User::where('phone_number', $phoneNumber)->first();
            $updateSuccessMessage = MessageSample::where('name', 'update_account_success')->first();
            $registerSuccessMessage = MessageSample::where('name', 'register_account_success')->first();

            if($user){
                //update database with new message
                $user->name = $message;
                $res = $user->save();

                if($res){
                    if($updateSuccessMessage){
                        return $updateSuccessMessage->content;
                    }
                    return "0|Ban da cap nhat tai khoan thanh cong";
                }
            }else{
                //create new record
                $user = new User();

                $user->phone_number = $phoneNumber;
                $user->name = $message;
                $res = $user->save();

                if($res){
                    $this->sendSMS($user->phone_number, 1);
                    if($registerSuccessMessage){
                        return $registerSuccessMessage->content;
                    }
                    return "0|Ban da dang ky tai khoan thanh cong";
                }
            }
        }

        if($registerFailMessage){
            return $registerFailMessage->content;
        }
        return "3|Sai Command Code";
    }

    /**
     * Send Unicode SMS to User
     *
     * @param $phoneNumber
     * @param $step
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSMS($phoneNumber, $step)
    {
        /*echo 'ready to send';
        die();*/
        $guideCreateAdsMessage = MessageSample::where('name', 'guide_register_ads')->first();
        $responseAdsMessage = MessageSample::where('name', 'response_register_ads')->first();
        $helper = new AppHelpers();
        $url = \Config::get('constants.SPEED_SMS_URL');

        switch($step){
            case 1:
                $content = 'Tai khoan cua ban da duoc tao thanh cong. De dang ky thong tin rao vat. Vui long soan theo cu phap TEN RAO VAT#NOI DUNG RAO VAT. Vi du: Ca phe#123 duong Ten Lua';
                if($guideCreateAdsMessage){
                    $content = $guideCreateAdsMessage->content;
                }
                break;
            case 2:
            default:
                $content = 'Noi dung rao vat cua ban dang duoc phe duyet. Vui long ghe website http://raobanmienphi.xyz de xem them chi tiet';
                if($responseAdsMessage){
                    $content = $responseAdsMessage->content;
                }
                break;
        }

        $body = [
            'to' => [$phoneNumber],
            'content' => $content,
            'sms_type' => 2,
            'sender' => ''
        ];

        $response = $helper->postCurlGuzzleRequest($url, $body);

        return $response;
    }

    /**
     * Get SMS Response from SpeedSMS
     *
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSMSResponse(Request $request)
    {
        $response = $request->all();
        $secretKey = \Config::get('constants.SPEED_SMS_API_SECRET_KEY');;
        $smsContent = $response['content'];
        $phoneNumber = $response['phone'];
        $user = User::where('phone_number', $phoneNumber)->first();

        if(!empty($smsContent) && $user /*&& $response['secret'] == $secretKey*/){
            $contentData = explode('#', $smsContent);
            $name = $contentData[0];
            $content = $contentData[1];

            $classifiedAd = new ClassifiedAds();
            $classifiedAd->user_id = $user->id;
            $classifiedAd->name = $name;
            $classifiedAd->content = $content;
            $res = $classifiedAd->save();

            if($res){
                $this->sendSMS($phoneNumber, 2);
            }
        }
    }
}
