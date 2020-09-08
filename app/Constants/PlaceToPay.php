<?php

namespace App\Constants;

class PlaceToPay
{
    /**
     * status of payments
     */
    public const OK = 'OK';
    public const FAILED = 'FAILED';
    public const APPROVED = 'APPROVED';
    public const APPROVED_PARTIAL = 'APPROVED_PARTIAL';
    public const PARTIAL_EXPIRED = 'PARTIAL_EXPIRED';
    public const REJECTED = 'REJECTED';
    public const PENDING = 'PENDING';
    public const PENDING_VALIDATION = 'PENDING_VALIDATION';
    public const REFUNDED = 'REFUNDED';

    public const MESSAGE_REVERSED = 'Se ha reversado el pago correctamente';

    /**
     * fields response
     */

    public const PROCESS_URL = 'processUrl';
    public const REQUEST_ID = 'requestId';

    /**
     * Methods allowed
     */
    public const CREATE_REQUEST = 'createRequest';
    public const REVERSE_REQUEST = 'reverseRequest';
    public const GET_REQUEST_INFORMATION = 'getRequestInformation';
}
