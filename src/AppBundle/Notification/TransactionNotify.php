<?php

namespace AppBundle\Notification;

use AppBundle\Entity\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class TransactionNotify extends AbstractNotify
{
    const END_POINT = "http://o4d9z.mocklab.io/notify";

    public static function notify(Transaction $transaction) {

        $client = new Client();

        $promise = $client->getAsync(self::END_POINT);

        $promise->then(
            function (ResponseInterface $res) {
                //TODO
            },
            function (RequestException $e) {
               //TODO
            }
        );

    }
}