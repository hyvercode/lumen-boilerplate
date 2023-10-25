<?php

namespace App\Traits;

use App\Utils\BusinessException;
use App\Utils\Constants;
use App\Utils\Monologger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

trait RequestService
{

    /**
     * @param $uri
     * @param $payload
     * @param $headers
     * @return string
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doPost($uri, $headers, $payload = [], Request $request)
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUri
            ]);
            if (isset($this->secret)) {
                $headers['x-api-key'] = $this->secret;
                $headers['fcm-key'] = Constants::FCM_KEY;
            }
            
            $payload['auth'] = $request->get('auth');

            $response = $client->post($uri,
                [
                    'json' => $payload,
                    'headers' => $headers
                ]
            );
            Monologger::logTelemetri(Constants::REQUEST, $request->auth['request_id'], $request, $request->get('auth')['user_id'], json_decode($response->getBody(), true));
        } catch (ClientException $e) {
            Monologger::log(Constants::ERROR, $e->getMessage(), $request->get('auth')['request_id']);
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9005, Constants::ERROR_CODE_9005);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param $uri
     * @param $query
     * @param $headers
     * @return string
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doGet($uri, $headers, $query = [], Request $request)
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUri,
            ]);

            $response = $client->get($uri .http_build_query(['auth' => $request->get('auth')]) . '&' . $query, array(
                    "headers" => [
                        'x-api-key' => $this->secret,
                        'authorization' => $headers['authorization'],
                        'fcm-key' => Constants::FCM_KEY
                    ]
                )
            );
            Monologger::logTelemetri(Constants::REQUEST, $request->get('auth')['request_id'], $request, $request->get('auth')['user_id'], json_decode($response->getBody(), true));
        } catch (ClientException $e) {
            Monologger::log(Constants::ERROR, $e->getMessage(), $request->get('auth')['request_id']);
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9005, Constants::ERROR_CODE_9005);
        }
        return json_decode($response->getBody(), true);
    }
}
