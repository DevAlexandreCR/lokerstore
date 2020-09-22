<?php

namespace App\Jobs;

use App\Constants\Logs;
use App\Constants\Payments;
use App\Repositories\Payments as Pay;
use App\Constants\PlaceToPay;
use App\Models\Order;
use App\Traits\HttpClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QueryStatusPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HttpClient;

    public $order;

    public $tries = 5;

    public $maxExceptions = 3;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param Pay $pay
     * @return void
     */
    public function handle(Pay $pay): void
    {
        logger()->channel(Logs::CHANNEL_PAYMENTS)->info('querying payment: ' . $this->order->payment->id .
            ' with status: ' . $this->order->payment->status);

        $response = $this->sendRequest(PlaceToPay::GET_REQUEST_INFORMATION, $this->order);

        $this->responseHandler($response, $pay);
    }

    public function responseHandler($response, Pay $payments): void
    {
        $status = $response->status->status;
        logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Payment ' . $this->order->payment->id .
                    ' is ' . $status . ' in P2P');
        switch ($status)
        {
            case PlaceToPay::APPROVED:
                $payments->setStatus($this->order->payment, $status);
                $payments->setDataPayment($this->order->payment, $response);
                break;
            case PlaceToPay::REJECTED:
                $payments->setStatus($this->order->payment, $status);
                break;
            default:
                $payments->setStatus($this->order->payment, Payments::STATUS_PENDING);
        }
    }
}
