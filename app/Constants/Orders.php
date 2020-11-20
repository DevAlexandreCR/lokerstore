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
            self::STATUS_CANCELED         => trans('orders.statuses.canceled'),
            self::STATUS_PENDING_PAY      => trans('orders.statuses.pending_pay'),
            self::STATUS_PENDING_SHIPMENT => trans('orders.statuses.pending_shipment'),
            self::STATUS_SENT             => trans('orders.statuses.sent'),
            self::STATUS_SUCCESS          => trans('orders.statuses.completed'),
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
                return trans('orders.statuses.pending_pay');
            case self::STATUS_PENDING_SHIPMENT:
                return trans('orders.statuses.pending_shipment');
            case self::STATUS_CANCELED:
                return trans('orders.statuses.canceled');
            case self::STATUS_REJECTED:
                return trans('orders.statuses.rejected');
            case self::STATUS_SENT:
                return trans('orders.statuses.sent');
            case self::STATUS_SUCCESS:
                return trans('orders.statuses.completed');
            case self::STATUS_FAILED:
                return trans('orders.statuses.failed');
            default:
                return '';
        }
    }
}
