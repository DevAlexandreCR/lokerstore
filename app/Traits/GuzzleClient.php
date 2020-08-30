<?php

namespace App\Traits;

use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;


trait GuzzleClient
{
    use Authentication;

    private $endPoint = 'api/session/';

    public function sendRequest(Order $order)
    {
        try {
            $client = $this->getClient();
            $response =  $client->post($this->endPoint,
                 [
                     'json' => $this->data($order)
                 ]);

            return json_decode($response->getBody()->getContents());

        } catch (ClientException $e) {
            dd($e);
            return json_decode($e->getResponse()->getBody()->getContents());
        } catch (ServerException $e) {
            dd($e);
            return json_decode($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return [
                'status' => [
                    'status' => 0,
                    'reason' => 'WR',
                    'message' => $e->getMessage(),
                    'date' => date('c'),
                ],
            ];
        }
    }

    private function data(Order $order): array
    {
        $auth = $this->getAuth();
        $expiration = date('c', strtotime('+2 days'));

        return [
            'auth' => $auth,
            'payment' => [
                'reference' => $order->id,
                'description' => 'pago de prueba',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->amount
                ]
            ],
            'expiration' => $expiration,
            'returnUrl' => config('app.url'),
            'ipAddress' => '127.0.0.1',
            'userAgent' => request()->header('User-Agent')
        ];
    }

    public function getClient(): Client
    {
        return new Client([
            'base_uri' => config('placetopay.baseUrl'),
            'timeout' => config('placetopay.timeout')
        ]);
    }
}
