<?php

namespace App\Models;

use App\Constants\Orders;
use App\Constants\Metrics;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    protected $fillable = ['date', 'measurable_id', 'status', 'total', 'metric'];

    public function scopeGeneralOrdersMetrics($query)
    {
        return $query->where('metric', Metrics::ORDERS);
    }

    public function scopeSellerOrdersMetrics($query)
    {
        return $query
            ->where('metric', Metrics::SELLER)
            ->where('status', Orders::STATUS_SENT);
    }
}
