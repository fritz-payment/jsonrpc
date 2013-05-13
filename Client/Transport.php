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
     * The method, which should actually send the request.
     * It should return the response (JSON) body or FALSE if something went wrong.
     * Error details should be returned through the methods getErrorCode() and getErrorMessage().
     * An expected transport error (e.g. HTTP error codes) should not throw an exception, but be
     * handled as an error.
     *
     * @param \FritzPayment\JsonRpc\Request   $request
     *
     * @return string|bool
     */
    public function send(Request $request);

    /**
     * @return int
     */
    public function getErrorCode();

    /**
     * @return string
     */
    public function getErrorMessage();
}
