<?php

namespace App\Constants;

class Orders
{
    public const STATUS_PENDING_PAY = 'pending_pay';
    public const STATUS_PENDING_SHIPMENT = 'pending_shipment';
    public const STATUS_SENT = 'sent';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUCCESS = 'completed';
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

    public static function statusesPaid(): array
    {
        return [
            self::STATUS_PENDING_SHIPMENT,
            self::STATUS_SENT,
            self::STATUS_SUCCESS
        ];
    }

    /**
     * @param string $status
     * @return string
     */
    public static function getTranslatedStatus(string $status): string
    {
        switch ($status) {
            case self::STATUS_PENDING_PAY:
                return trans('Pending payment');
            case self::STATUS_PENDING_SHIPMENT:
                return trans('Pending shipment');
            case self::STATUS_CANCELED:
                return trans('Canceled');
            case self::STATUS_REJECTED:
                return trans('Payment rejected');
            case self::STATUS_SENT:
                return trans('Sent');
            case self::STATUS_SUCCESS:
                return trans('Completed');
            case self::STATUS_FAILED:
                return trans('Failed');
            default:
                return '';
        }
    }
}
