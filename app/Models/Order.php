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
}
