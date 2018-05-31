<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AppHelpers;
use App\User;
use App\MessageSample;
use App\Events\RegisterAccount;

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
                    event(new RegisterAccount($user));
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
        echo 'phonenumber: '.$phoneNumber;die();
        $guideCreateAdsMessage = MessageSample::where('name', 'guide_register_ads')->first();
        $responseAdsMessage = MessageSample::where('name', 'response_register_ads')->first();
        $helper = new AppHelpers();
        $url = \Config::get('constants.SPEED_SMS_URL');

        switch($step){
            case 1:
                $content = 'Chào bạn, để đăng ký thông tin rao vặt, vui lòng soạn nội dung theo cú pháp <tên>|<nội_dung>. Ví dụ: Cà phê|123 Tên Lửa';
                if($guideCreateAdsMessage){
                    $content = $guideCreateAdsMessage->content;
                }
                break;
            case 2:
            default:
                $content = 'Nội dung rao vặt của bạn đã được gửi và đang chờ phê duyệt. Vui lòng ghé website: http://raobanmienphi.xyz để xem';
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

    public function getSMSResponse(Request $request)
    {
        return $request->all();
    }
}
