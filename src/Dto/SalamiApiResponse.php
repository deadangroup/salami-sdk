<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@dgl.co.ke>
 *
 * <code> Build something people want </code>
 *
 */

namespace DGL\Salami\Dto;

/**
 *
 */
class SalamiApiResponse
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
     * @var array
     */
    public $data = [];

    /**
     * @param  array  $callbackPayload
     *
     * @return static
     */
    public static function buildFromCallback(array $callbackPayload = [])
    {
        $SalamiApiResponse = new static();
        $SalamiApiResponse->status_code = 200;
        $SalamiApiResponse->status_name = "HTTP_OK";
        $SalamiApiResponse->message = "OK";
        $SalamiApiResponse->data = $callbackPayload;

        return $SalamiApiResponse;
    }

    /**
     * @param  array  $apiResponsePayload
     *
     * @return static
     */
    public static function buildFromApiCall(array $apiResponsePayload = [])
    {
        $SalamiApiResponse = new static();
        $SalamiApiResponse->status_code = isset($apiResponsePayload['status_code']) ? $apiResponsePayload['status_code'] : null;
        $SalamiApiResponse->status_name = isset($apiResponsePayload['status_name']) ? $apiResponsePayload['status_name'] : null;
        $SalamiApiResponse->message = $apiResponsePayload['message'];
        $SalamiApiResponse->data = $apiResponsePayload;

        return $SalamiApiResponse;
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
        if (! $key) {
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
