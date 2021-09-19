<?php

namespace AppBundle\Service;

use AppBundle\Entity\Interfaces\IUserTransaction;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Validator\CheckIfValueGreaterEqualThanZeroValidator;
use AppBundle\Validator\CheckIfWalletIsNotNullValidator;
use AppBundle\Validator\Validator;
use AppBundle\Notification\TransactionNotify;

abstract class TransactionService extends AbstractService
{
    /**
     * @var IUserTransaction
     */
    protected $walletOwner;

    /**
     * @var Wallet
     */
    protected $wallet;

    /**
     * @param Transaction $transaction
     */
    abstract protected function confirm(Transaction $transaction);

    /**
     * @param IUserTransaction $walletOwner
     */
    public function attachWalletOwner(IUserTransaction $walletOwner)
    {
        $this->walletOwner = $walletOwner;
        $this->wallet = $this->walletOwner->getWallet();
    }

    /**
     * @return CheckIfWalletIsNotNullValidator
     */
    protected function getTransactionValidators(float $value): Validator
    {
        $validator = new CheckIfWalletIsNotNullValidator($this->wallet);
        $validator->linkWith(new CheckIfValueGreaterEqualThanZeroValidator($value));
        return $validator;
    }

    /**
     * @param Transaction $transaction
     */
    protected function notify(Transaction $transaction) {
        TransactionNotify::notify($transaction);
    }

}