<?php

namespace App\Models;

use App\Constants\Metrics;
use App\Constants\Orders;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Metric extends Model
{
    protected $fillable = ['date', 'measurable_id', 'status', 'total', 'metric'];

    public function measurable(): MorphTo
    {
        return $this->morphTo('measurable', 'metric');
    }

    public function scopeGeneralOrdersMetrics(Builder $query): Builder
    {
        return $query
            ->where('metric', Metrics::ORDERS)
            ->orderBy('date', 'asc');
    }

    public function scopeSellerOrdersMetrics(Builder $query): Builder
    {
        return $query
            ->with('measurable')
            ->select('measurable_id', 'status', 'metric')
            ->selectRaw('SUM(total) as total')
            ->selectRaw('SUM(amount) as amount')
            ->whereDate('date', '>', now()->firstOfMonth()->format('Y-m-d'))
            ->where('metric', Metrics::SELLER)
            ->whereIn('status', [
                Orders::STATUS_SUCCESS,
                Orders::STATUS_SENT,
            ])
            ->groupBy('measurable_id', 'status', 'metric')
            ->orderBy('amount', 'desc')
            ->limit(5);
    }

    public function scopeCategoryMoreSoldMetrics(Builder $query): Builder
    {
        return $query
            ->with('measurable')
            ->select('measurable_id', 'status', 'metric')
            ->selectRaw('SUM(total) as total')
            ->whereDate('date', '>', now()->subDays(30)->format('Y-m-d'))
            ->where('metric', Metrics::CATEGORIES)
            ->whereIn('status', [
                Orders::STATUS_SUCCESS,
                Orders::STATUS_SENT,
            ])
            ->groupBy('measurable_id', 'status', 'metric')
            ->orderBy('total', 'desc')
            ->limit(3);
    }

    public function scopePendingShipmentOrders(Builder $query): Builder
    {
        return $query
            ->select('id')
            ->where('metric', Metrics::ORDERS)
            ->where('status', Orders::STATUS_PENDING_SHIPMENT);
    }

    public function scopePercentMetrics(Builder $query): Builder
    {
        return $query
            ->select('date', 'metric', 'amount', 'status')
            ->where('metric', Metrics::ORDERS)
            ->whereDate('date', '>=', now()->subMonth()->format('Y-m') . '-01')
            ->whereIn('status', [
                Orders::STATUS_PENDING_SHIPMENT,
                Orders::STATUS_SUCCESS,
                Orders::STATUS_SENT,
            ])
            ->orderBy('date');
    }
}
