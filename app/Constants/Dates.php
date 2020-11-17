<?php

namespace App\Constants;

use MyCLabs\Enum\Enum;

class Dates extends Enum
{
    public const MONDAY = 'Monday';
    public const TUESDAY = 'Tuesday';
    public const WEDNESDAY = 'Wednesday';
    public const THURSDAY = 'Thursday';
    public const FRIDAY = 'Friday';
    public const SATURDAY = 'Saturday';
    public const SUNDAY = 'Sunday';

    public static function getTranslatedDay(string $day)
    {
        switch ($day) {
            case self::MONDAY:
                return trans(self::MONDAY);
            case self::TUESDAY:
                return trans(self::TUESDAY);
            case self::WEDNESDAY:
                return trans(self::WEDNESDAY);
            case self::THURSDAY:
                return trans(self::THURSDAY);
            case self::FRIDAY:
                return trans(self::FRIDAY);
            case self::SATURDAY:
                return trans(self::SATURDAY);
            case self::SUNDAY:
                return trans(self::SUNDAY);
            default:
                return '';
        }
    }
}
