<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Rpc\Codec;
use FritzPayment\JsonRpc\Rpc\Codec;
use FritzPayment\JsonRpc\Request;
use FritzPayment\JsonRpc\Response;
class JsonRpc10 implements Codec
{
    const VERSION = '1.0';

    /**
     * @return Request
     */
    public function getRequest() {
        // TODO: Implement getRequest() method.
    }

    /**
     * @return Response
     */
    public function getResponse() {
        // TODO: Implement getResponse() method.
    }

    /**
     * @param \FritzPayment\JsonRpc\Request $request
     *
     * @return bool
     */
    public function isCodecRequest(Request $request) {
        return $request->getVersion() == self::VERSION;
    }

    /**
     * @param \FritzPayment\JsonRpc\Response $response
     *
     * @return bool
     */
    public function isCodecResponse(Response $response) {
        return $response->getVersion() == self::VERSION;
    }
}
