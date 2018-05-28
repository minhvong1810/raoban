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
     * @return bool|\Psr\Http\Message\StreamInterface|string
     */
    public function getGuzzleRequest($url)
    {
        $client = new Client();
        $request = $client->get($url);

        try {
            $response = $request->getBody();
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
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function postGuzzleRequest($url, $body)
    {
        $client = new Client();

        try {
            //var_dump($body);die();
            $result = $client->post($url, ['form_params'=>$body]);
        } catch (\Exception $e) {
            report($e);
            Log::info('Error: ', $e);

            return false;
        }

        return $result;
    }

}