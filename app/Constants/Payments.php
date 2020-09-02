<?php

namespace App\Constants;

class Payments
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_ACCEPTED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_CANCELED = 'CANCELED';
    public const FAILED = 'FAILED';
    public const PENDING_VALIDATION = 'PENDING_VALIDATION';
    public const REFUNDED = 'REFUNDED';
}
