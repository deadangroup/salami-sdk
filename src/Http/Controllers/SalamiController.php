<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

namespace Deadan\Salami\Http\Controllers;

use Deadan\Salami\Facades\SalamiPay;
use Illuminate\Http\Request;

/**
 * Class SalamiController.
 */
class SalamiController extends Controller
{
    /**
     * Receives a callback from Salami of an incoming payment
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function salamiCallback(Request $request)
    {
        return SalamiPay::processWebhook($request);
    }
}
