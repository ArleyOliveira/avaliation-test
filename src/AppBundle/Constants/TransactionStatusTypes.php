<?php

namespace AppBundle\Constants;

class TransactionStatusTypes extends Enum
{
    const PENDING = "PENDING";
    const CREDIT = "CREDIT";
    const OVERTURNED = "OVERTURNED";
}