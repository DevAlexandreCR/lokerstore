<?php

namespace App\Constants;

class Orders
{
    public const STATUS_PENDING_PAY = 'pending_pay';
    public const STATUS_PENDING_SHIPMENT = 'pending_shipment';
    public const STATUS_SENT = 'sent';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUCCESS = 'complete';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_FAILED = 'failed';

    public static function getAllStatus(): array
    {
        return [
            self::STATUS_PENDING_PAY,
            self::STATUS_FAILED,
            self::STATUS_CANCELED,
            self::STATUS_SUCCESS,
            self::STATUS_REJECTED,
            self::STATUS_SENT,
            self::STATUS_PENDING_SHIPMENT,
        ];
    }

    public static function getClientStatus(): array
    {
        return [
            self::STATUS_CANCELED => __('Canceled'),
            self::STATUS_PENDING_PAY => __('Pending payment'),
            self::STATUS_PENDING_SHIPMENT => __('Pending shipment'),
            self::STATUS_SENT => __('Sent'),
            self::STATUS_SUCCESS => __('Completo'),
        ];
    }

    /**
     * @param string $status
     * @return string
     */
    public static function getTranslatedStatus(string $status): string
    {
        switch ($status) {
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
}
