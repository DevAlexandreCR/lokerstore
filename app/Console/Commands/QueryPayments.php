<?php

namespace App\Console\Commands;

use App\Constants\Logs;
use App\Constants\Orders;
use App\Jobs\QueryStatusPayment;
use App\Models\Order;
use Illuminate\Console\Command;

class QueryPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query pendings payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Order $orderModel
     * @return void
     */
    public function handle(Order $orderModel)
    {
        $pendingsOrders = $orderModel->where('status', Orders::STATUS_PENDING_PAY)->get();
        logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Payments pendings: ' . $pendingsOrders->count());
        $pendingsOrders->each(function($model) use ($orderModel){
            $order = $orderModel->find($model->id);
            dispatch(new QueryStatusPayment($order));
        });
    }
}