<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Payments extends Enum
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_ACCEPTED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_CANCELED = 'CANCELED';
    public const FAILED = 'FAILED';
    public const PENDING_VALIDATION = 'PENDING_VALIDATION';
    public const REFUNDED = 'REFUNDED';

    public static function getAllStatus(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_ACCEPTED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELED,
            self::FAILED,
            self::PENDING_VALIDATION,
            self::REFUNDED,
        ];
    }
}
