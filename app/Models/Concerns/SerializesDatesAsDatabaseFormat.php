<?php

namespace App\Models\Concerns;

use DateTimeInterface;

trait SerializesDatesAsDatabaseFormat
{
    // Keeps the pre-Laravel 7 "Y-m-d H:i:s" format in toArray()/JSON instead of ISO-8601.
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
