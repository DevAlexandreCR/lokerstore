<?php

namespace App\Models;

use App\Constants\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['user_id', 'status'];

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
                break;
            case Orders::STATUS_PENDING_SHIPMENT:
                return __('Pending shipment');
                break;
            case Orders::STATUS_CANCELED:
                return __('Canceled');
                break;case Orders::STATUS_REJECTED:
            return __('Payment rejected');
                break;
            case Orders::STATUS_SENT:
                return __('Sent');
                break;
            case Orders::STATUS_SUCCESS:
                return __('Complete');
                break;
        }
    }
}
