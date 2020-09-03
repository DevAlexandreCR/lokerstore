<?php

namespace App\Traits;

use App\Constants\PlaceToPay;
use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

trait GuzzleClient
{
    use Authentication;

    private $endPoint = 'api/session/';

    /**
     * @param string $method
     * @param Order $order
     * @return array[]|mixed
     */
    public function sendRequest(string $method, Order $order)
    {
        try {
            $client = $this->getClient();
            switch ($method)
            {
                case PlaceToPay::CREATE_REQUEST:
                    $response =  $client->post($this->endPoint,
                        [
                            'json' => $this->data($order)
                        ]);
                    break;
                case PlaceToPay::GET_REQUEST_INFORMATION:
                    $response = $client->post($this->endPoint . $order->payment->request_id,
                        [
                            'json' => [
                                'auth' => $this->getAuth()
                            ]
                        ]);
                    break;
                default:
                    return [
                        'status' => [
                            'status' => 0,
                            'reason' => 'WR',
                            'message' => 'Bad request, method undefined',
                            'date' => date('c'),
                        ],
                    ];
            }

            return json_decode($response->getBody()->getContents());

        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        } catch (ServerException $e) {
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
                'description' => 'user ' . $order->user->email . ' pay order ' . $order->id,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->amount
                ]
            ],
            'expiration' => $expiration,
            'returnUrl' => route('user.order.show', [auth()->id(), $order->id]),
            'ipAddress' => request()->getClientIp(),
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
