<?php

namespace App\Domain\Country;

use App\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The country you requested does not exist.';
}
