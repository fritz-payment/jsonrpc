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
use FritzPayment\JsonRpc\Response;
class CodecStub implements \FritzPayment\JsonRpc\Rpc\Codec
{
    /**
     * @return Request
     */
    public function getRequest() {
        return new RequestStub();
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return new ResponseStub();
    }

    /**
     * @param \FritzPayment\JsonRpc\Request $request
     *
     * @return bool
     */
    public function isCodecRequest(\FritzPayment\JsonRpc\Request $request) {
        return ($request instanceof RequestStub);
    }

    /**
     * @param \FritzPayment\JsonRpc\Response $response
     *
     * @return bool
     */
    public function isCodecResponse(\FritzPayment\JsonRpc\Response $response) {
        return ($response instanceof ResponseStub);
    }
}
