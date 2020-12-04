<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Logs extends Enum
{
    public const CHANNEL_PAYMENTS = 'payments';
    public const CHANNEL_USERS = 'users';
    public const CHANNEL_SLACK = 'slack';
    public const CHANNEL_DAILY = 'daily';
}
