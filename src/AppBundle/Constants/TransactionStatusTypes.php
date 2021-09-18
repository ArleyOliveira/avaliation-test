<?php

namespace AppBundle\Constants;

class TransactionStatusTypes extends Enum
{
    const PENDING = "PENDING";
    const CONFIRMED = "CONFIRMED";
    const OVERTURNED = "OVERTURNED";
}