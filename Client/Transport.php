<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Client;
use FritzPayment\JsonRpc\Request;
use FritzPayment\JsonRpc\Rpc\Codec;

interface Transport
{
    /**
     * @param $url
     *
     * @return bool
     */
    public function setUrl($url);

    /**
     * @param \FritzPayment\JsonRpc\Request   $request
     *
     * @return string
     */
    public function send(Request $request);
}
