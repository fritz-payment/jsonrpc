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
class RequestStub extends \FritzPayment\JsonRpc\Request
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
     * Return the json encoded request as a string. It is the request implementation's job
     * to ensure the correctness of the JSON string.
     *
     * @return string
     */
    public function getRequestBody() {
        return 'requestBody';
    }
}
