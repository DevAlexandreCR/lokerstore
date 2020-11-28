<?php

namespace App\Models;

use App\Constants\Orders;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['user_id', 'admin_id', 'status', 'amount'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @param $query
     * @param string|null $status
     * @return Builder|null
     */
    public function scopeStatus(Builder $query, string $status = null): ?Builder
    {
        if (!$status) {
            return null;
        }

        return $query->where('status', $status);
    }

    /**
     * @param Builder $query
     * @param string|null $from
     * @param string|null $until
     * @return Builder|null
     */
    public function scopeDate(Builder $query, string $from = null, string $until = null): ?Builder
    {
        if (!$from) {
            $from = now()->subYear()->format('Y-m-d');
        }

        if (!$until) {
            $until = date('c', strtotime('+1 days'));
        }

        return $query->whereBetween('created_at', [$from, $until]);
    }

    /**
     * @param $query
     * @param string|null $email
     * @return Builder|null
     */
    public function scopeUserEmail(Builder $query, string $email = null): ?Builder
    {
        if ($email) {
            return $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });
        }

        return null;
    }

    public function scopePendingShipmentOrders(Builder $query): Builder
    {
        return $query
            ->select('id')
            ->whereDate('created_at', '>', now()->subMonth())
            ->where('status', Orders::STATUS_PENDING_SHIPMENT);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        switch ($this->status) {
            case Orders::STATUS_PENDING_PAY:
                return trans('orders.statuses.pending_pay');
            case Orders::STATUS_PENDING_SHIPMENT:
                return trans('orders.statuses.pending_shipment');
            case Orders::STATUS_CANCELED:
                return trans('orders.statuses.canceled');
            case Orders::STATUS_REJECTED:
                return __('orders.statuses.rejected');
            case Orders::STATUS_SENT:
                return trans('orders.statuses.sent');
            case Orders::STATUS_SUCCESS:
                return trans('orders.statuses.completed');
            case Orders::STATUS_FAILED:
                return trans('orders.statuses.failed');
            default:
                return trans('');
        }
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return round($this->amount, 0, PHP_ROUND_HALF_UP) . 'COP';
    }

    /**
     * @return array
     */
    public function getAllStatus(): array
    {
        return [
            Orders::STATUS_CANCELED         => trans('orders.statuses.canceled'),
            Orders::STATUS_PENDING_PAY      => trans('orders.statuses.pending_pay'),
            Orders::STATUS_PENDING_SHIPMENT => trans('orders.statuses.pending_shipment'),
            Orders::STATUS_SENT             => trans('orders.statuses.sent'),
            Orders::STATUS_SUCCESS          => trans('orders.statuses.completed'),
        ];
    }
}
