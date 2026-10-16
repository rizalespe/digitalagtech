<?php

namespace App\Enums;

enum EventType: string
{
    case Webinar = 'webinar';
    case Workshop = 'workshop';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
