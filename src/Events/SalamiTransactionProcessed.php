<?php

namespace Deadan\Salami\Events;

class SalamiTransactionProcessed extends Event
{
    /**
     * @var \Deadan\Salami\Transaction
     */
    public $transaction;

    /**
     * SalamiTransactionProcessed constructor.
     *
     * @param  \Deadan\Salami\Events\Transaction  $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return \Deadan\Salami\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
}
