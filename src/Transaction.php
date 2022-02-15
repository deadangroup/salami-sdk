<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami;

class Transaction
{
    /**
     * @var
     */
    public $status_code;

    /**
     * @var
     */
    public $status_name;

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $errors;

    /**
     * @var array
     */
    public $data = [
        'id',
        'payer_account',
        'payer_name',
        'payee_account',
        'payee_name',
        'reference',
        'transaction_id',
        'amount',
        'transaction_time',
        'narration',
        'raw_details' => [],
        'status',
        'currency',
        'payment_provider',
        'transaction_type',
        'transaction_sub_type',
        'app_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @param  array  $callbackPayload
     *
     * @return static
     */
    public static function buildFromCallback(array $callbackPayload = [])
    {
        $transaction = new static();
        $transaction->status_code = 200;
        $transaction->status_name = "HTTP_OK";
        $transaction->message = "OK";
        $transaction->errors = null;
        $transaction->data = $callbackPayload;

        return $transaction;
    }

    /**
     * @param  array  $apiResponsePayload
     *
     * @return static
     */
    public static function buildFromApiCall(array $apiResponsePayload = [])
    {
        $transaction = new static();
        $transaction->status_code = $apiResponsePayload['status_code'];
        $transaction->message = $apiResponsePayload['message'];
        $transaction->message = $apiResponsePayload['message'];
        $transaction->errors = $apiResponsePayload['errors'];
        $transaction->data = $apiResponsePayload['data'];

        return $transaction;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (!$key) {
            return;
        }

        return $this->data[$key];
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return 'STATUS_COMPLETED' == $this->getAttribute('status');
    }

    /**
     * @return bool
     */
    public function isDeclined()
    {
        return 'STATUS_DECLINED' === $this->getAttribute('status');
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return 'STATUS_FAILED' === $this->getAttribute('status');
    }
}
