<?php

namespace App\Models;

use App\Constants\Orders;
use App\Constants\Metrics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Metric extends Model
{
    protected $fillable = ['date', 'measurable_id', 'status', 'total', 'metric'];

    public function measurable(): MorphTo
    {
        return $this->morphTo('measurable', 'metric');
    }

    public function scopeGeneralOrdersMetrics($query)
    {
        return $query
            ->where('metric', Metrics::ORDERS)
            ->orderBy('date', 'asc');
    }

    public function scopeSellerOrdersMetrics($query)
    {
        return $query
            ->with('measurable')
            ->select('measurable_id', 'status', 'metric')
            ->where('metric', Metrics::SELLER)
            ->where('status', Orders::STATUS_SENT)
            ->selectRaw('SUM(total) as total')
            ->selectRaw('SUM(amount) as amount')
            ->groupBy('measurable_id', 'status', 'metric')
            ->orderBy('amount', 'desc')
            ->limit(5);
    }

    public function scopeCategoryMoreSoldMetrics($query)
    {
        return $query
            ->with('measurable')
            ->select('measurable_id', 'status', 'metric')
            ->where('metric', Metrics::CATEGORIES)
            ->where('status', Orders::STATUS_SENT)
            ->selectRaw('SUM(total) as total')
            ->groupBy('measurable_id', 'status', 'metric')
            ->orderBy('total', 'desc')
            ->limit(3);
    }

    public function scopePendingShipmentOrders($query)
    {
        return $query
            ->select('id')
            ->where('metric', Metrics::ORDERS)
            ->where('status', Orders::STATUS_PENDING_SHIPMENT);
    }
}
