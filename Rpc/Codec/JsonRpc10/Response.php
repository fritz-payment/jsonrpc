<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10;
use FritzPayment\JsonRpc\Response as BaseResponse;

class Response extends BaseResponse
{

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc10::VERSION;
    }

    /**
     * @return string
     */
    public function getResultString() {
        // TODO: Implement getResultString() method.
    }

    /**
     * @return \stdClass|array
     */
    public function getResultJson() {
        // TODO: Implement getResultJson() method.
    }

    /**
     * Will be called by the transport. This method should take the raw response body and
     * create the applicable result objects.
     *
     * @return bool
     */
    public function parseResponse() {
        // TODO: Implement parseResponse() method.
    }
}
