<?php

namespace App\Traits;

use App\Constants\PlaceToPay;
use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\Model;

trait GuzzleClient
{
    use Authentication;

    private $endPoint = 'api/session/';
    private $reverseEndPoint = 'api/reverse/';

    /**
     * send request to placetopay api
     * @param string $method
     * @param Order|Model $order
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
                case PlaceToPay::REVERSE_REQUEST:
                    $response = $client->post($this->reverseEndPoint,
                        [
                            'json' => [
                                'auth' => $this->getAuth(),
                                'internalReference' => $order->payment->pay_reference
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

            return json_decode($response->getBody()->getContents(), true);

        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
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

    /**
     * build data to send to request
     * @param Order $order
     * @return array
     */
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

    /**
     * Initialize client from Guzzle
     * @return Client
     */
    public function getClient(): Client
    {
        return new Client([
            'base_uri' => config('placetopay.baseUrl'),
            'timeout' => config('placetopay.timeout')
        ]);
    }
}
