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
use FritzPayment\JsonRpc\Error;

/**
 * JSON RPC 2.0 Codec
 *
 * @see http://www.jsonrpc.org/specification
 */
class JsonRpc20 implements Codec
{
    const VERSION = '2.0';

    /**
     * @return Request
     */
    public function getRequest() {
        return new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Request();
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Response();
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

    /**
     * @param \FritzPayment\JsonRpc\Error $error
     *
     * @return bool
     */
    public function isCodecError(Error $error) {
        return $error->getVersion() == self::VERSION;
    }
}
