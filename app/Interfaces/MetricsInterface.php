<?php

namespace App\Interfaces;

use App\Constants\Payments as Pay;
use App\Constants\PlaceToPay;
use App\Http\Requests\Admin\Orders\indexRequest;
use App\Models\Order;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Repositories\Payments;
use App\Traits\HttpClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Reports\ReportRequest;

interface MetricsInterface
{
    /**
     * @return array
     */
    public function homeMetrics(): array;

    /**
     * @param ReportRequest $request
     * @return mixed
     */
    public function reports(ReportRequest $request);
}
