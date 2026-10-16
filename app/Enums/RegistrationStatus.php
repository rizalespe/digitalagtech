<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Registered = 'registered';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Attended = 'attended';
    case Cancelled = 'cancelled';
}
