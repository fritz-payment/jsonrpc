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
use FritzPayment\JsonRpc\Request;
use FritzPayment\JsonRpc\Rpc\Codec;

class TransportStub implements \FritzPayment\JsonRpc\Client\Transport
{
    public $urlSetCorrectly = true;

    /**
     * @param $url
     *
     * @return bool
     */
    public function setUrl($url) {
        return $this->urlSetCorrectly;
    }

    /**
     * @param \FritzPayment\JsonRpc\Request   $request
     *
     * @return string
     */
    public function send(Request $request) {
        return 'body';
    }

    /**
     * @return int
     */
    public function getErrorCode() {
        return 1;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return 'error';
    }
}
