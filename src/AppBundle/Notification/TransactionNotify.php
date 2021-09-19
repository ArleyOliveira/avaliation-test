<?php

namespace AppBundle\Notification;

use AppBundle\Entity\Transaction;
use AppBundle\Service\Http\ClientHttpService;

class TransactionNotify extends AbstractNotify
{
    const END_POINT = "http://o4d9z.mocklab.io/notify";

    public static function notify(Transaction $transaction)
    {
        $client = new ClientHttpService();

        $client->requestAsync('GET', self::END_POINT, array(), function (\stdClass $responseData) {
            //TODO
        });
    }
}