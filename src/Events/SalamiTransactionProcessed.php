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
     * @var string
     */
    public $context;

    /**
     * SalamiTransactionProcessed constructor.
     *
     * @param  \Deadan\Salami\Transaction  $transaction
     */
    public function __construct(Transaction $transaction, $context)
    {
        $this->transaction = $transaction;
        $this->context = $context;
    }

    /**
     * @return \Deadan\Salami\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }
}
