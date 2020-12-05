<?php

namespace App\Traits;

use App\Constants\PlaceToPay;
use App\Models\Order;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

trait HttpClient
{
    use Authentication;

    private string $endPoint = 'api/session/';
    private string $reverseEndPoint = 'api/reverse/';

    /**
     * send request to placeToPay api
     * @param string $method
     * @param Order|Model $order
     * @return array[]|mixed
     */
    public function sendRequest(string $method, Order $order)
    {
        try {
            switch ($method) {
                case PlaceToPay::CREATE_REQUEST:
                    return  Http::asJson()->post(
                        config('placetopay.baseUrl') . $this->endPoint,
                        $this->data($order)
                    )->object();
                case PlaceToPay::GET_REQUEST_INFORMATION:
                    return Http::post(
                        config('placetopay.baseUrl') . $this->endPoint .
                        $order->payment->request_id,
                        [
                            'auth' => $this->getAuth(),
                        ]
                    )->object();
                case PlaceToPay::REVERSE_REQUEST:
                    return Http::post(
                        config('placetopay.baseUrl') . $this->reverseEndPoint,
                        [
                            'auth' => $this->getAuth(),
                            'internalReference' => $order->payment->reference,

                        ]
                    )->object();
                default:
                    return json_encode([
                        'status' => [
                            'status' => 0,
                            'reason' => 'WR',
                            'message' => 'Bad request, method undefined',
                            'date' => date('c'),
                        ],
                    ], JSON_THROW_ON_ERROR);
            }
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        } catch (HttpResponseException $e) {
            return json_encode([
                'status' => [
                    'status' => 0,
                    'reason' => 'WR',
                    'message' => $e->getMessage(),
                    'date' => date('c'),
                ],
            ], JSON_THROW_ON_ERROR);
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
                    'total' => $order->amount,
                ],
            ],
            'expiration' => $expiration,
            'returnUrl' => route('user.order.show', [auth()->id(), $order->id]),
            'ipAddress' => request()->getClientIp(),
            'userAgent' => request()->header('User-Agent'),
        ];
    }
}
