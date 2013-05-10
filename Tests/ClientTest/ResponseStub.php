<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests\ClientTest;
class ResponseStub extends \FritzPayment\JsonRpc\Response
{

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return 'stub';
    }

    /**
     * @return string
     */
    public function getResultString() {
        return 'resultString';
    }

    /**
     * @return \stdClass|array
     */
    public function getResultJson() {
        return new \stdClass();
    }

    /**
     * Will be called by the transport. This method should take the raw response body and
     * create the applicable result objects.
     *
     * @return bool
     */
    public function parseResponse() {
        return true;
    }
}
