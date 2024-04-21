<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{
    /** Parse ISO 8601 date to MySql Date string */
    public function parseISO8601MysqlDate($isoDatetime)
    {
        $dateTime = Carbon::parse($isoDatetime);
        return $dateTime->format('Y-m-d');
    }

    /** Parse ISO 8601 date to MySql Datetime string */
    public function parseISO8601MysqlDatetime($isoDatetime)
    {
        $dateTime = Carbon::parse($isoDatetime);
        return $dateTime->format('Y-m-d H:i:s');
    }
}
