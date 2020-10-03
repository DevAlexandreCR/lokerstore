<?php

namespace App\Models;

use App\Constants\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'amount'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeStatus($query, string $status = null)
    {
        return $query->where('status', $status ?: Orders::STATUS_PENDING_SHIPMENT);
    }
    public function scopeDate($query, string $date = null)
    {
        if ($date) {
            return $query->whereDate('created_at', $date);
        }

        return null;
    }

    public function scopeUserEmail($query, string $email = null)
    {
        if ($email){
            return $query->whereHas('user', function($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });
        }

        return null;
    }


    public function getStatus(): string
    {
        switch ($this->status)
        {
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
        }
    }

    public function getAmount() : string
    {
        return round($this->amount, 0,  PHP_ROUND_HALF_UP) . 'COP';
    }

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
