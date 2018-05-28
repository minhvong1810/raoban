<?php
/**
 * Created by PhpStorm.
 * User: minhvong
 * Date: 5/26/18
 * Time: 9:13 PM
 */

namespace App\Http\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Contracts\Logging\Log;

class AppHelpers
{
    /**
     * @param $url
     * @return bool|\Psr\Http\Message\StreamInterface
     * @throws GuzzleException
     */
    public function getGuzzleRequest($url)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', $url);
        } catch (\Exception $e) {
            report($e);
            Log::info('Error: ', $e);

            return false;
        }

        return $response;
    }

    /**
     * @param $url
     * @param $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function postGuzzleRequest($url, $body)
    {
        $client = new Client();

        try {
            $response = $client->request('POST', $url, ['form_params' => $body]);
        } catch (\Exception $e) {
            report($e);
            Log::info('Error: ', $e);

            return false;
        }

        return $response;
    }

    /**
     * @param $url
     * @param $body
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function postCurlGuzzleRequest($url, $body)
    {
        $client = new Client();

        try {
            $response = $client->request('POST', $url,
                ['curl' => [
                    CURLOPT_HEADER => false,
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_VERBOSE => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_USERPWD => \Config::get('constants.SPEED_SMS_API_ACCESS_TOKEN').':x'
            ]]
            );
        } catch (\Exception $e) {
            report($e);
            Log::info('Error: ', $e);

            return false;
        }

        return $response;
    }

}