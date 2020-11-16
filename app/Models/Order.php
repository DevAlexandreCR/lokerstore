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
     * @param string|null $date
     * @return Builder|null
     */
    public function scopeDate(Builder $query, string $date = null): ?Builder
    {
        if ($date) {
            return $query->whereDate('created_at', $date);
        }

        return null;
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

    /**
     * @return string
     */
    public function getStatus(): string
    {
        switch ($this->status) {
            case Orders::STATUS_PENDING_PAY:
                return __('Pending payment');
            case Orders::STATUS_PENDING_SHIPMENT:
                return __('Pending shipment');
            case Orders::STATUS_CANCELED:
                return __('Canceled');
                case Orders::STATUS_REJECTED:
            return __('Payment rejected');
            case Orders::STATUS_SENT:
                return __('Sent');
            case Orders::STATUS_SUCCESS:
                return __('Complete');
            case Orders::STATUS_FAILED:
                return __('Failed');
            default:
                return __('');
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
            Orders::STATUS_CANCELED => __('Canceled'),
            Orders::STATUS_PENDING_PAY => __('Pending payment'),
            Orders::STATUS_PENDING_SHIPMENT => __('Pending shipment'),
            Orders::STATUS_SENT => __('Sent'),
            Orders::STATUS_SUCCESS => __('Completo'),
        ];
    }
}
