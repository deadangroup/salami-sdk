<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\Transaction;
use Illuminate\Queue\SerializesModels;

class SalamiTransactionProcessed
{
    use SerializesModels;

    /**
     * @var \Deadan\Salami\Transaction
     */
    public $transaction;

    /**
     * SalamiTransactionProcessed constructor.
     *
     * @param  \Deadan\Salami\Transaction  $transaction
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
