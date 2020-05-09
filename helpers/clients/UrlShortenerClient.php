<?php

namespace app\helpers\clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class UrlShortenerClient
{
    /**
     * @param string $url
     * @return string
     * @throws NotValidDataException
     * @throws UrlClientException
     */
    public static function action($url)
    {
        $client = new Client([
            'base_uri' => 'http://urlshortener.local',
            'timeout'  => 10.0,
        ]);
        try {
            $response = $client->post('/', [
                'json' => [
                    'url' => $url,
                ]
            ]);
            $body = json_decode($response->getBody());
            return $body->code;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $message = $e->getResponse()->getBody()->getContents();
            if ($response->getStatusCode() == 422) {
                throw new NotValidDataException($message, $response->getStatusCode(), $e);
            }
            throw new UrlClientException($message, $response->getStatusCode(), $e);
        }
    }
}
