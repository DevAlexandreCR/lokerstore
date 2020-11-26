<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Payers extends Enum
{
    public const DOCUMENT_TYPE_CC = 'CC';
    public const DOCUMENT_TYPE_AS = 'AS';
    public const DOCUMENT_TYPE_CE = 'CE';
    public const DOCUMENT_TYPE_PA = 'PA';
    public const DOCUMENT_TYPE_RC = 'RC';
    public const DOCUMENT_TYPE_TI = 'TI';
}
