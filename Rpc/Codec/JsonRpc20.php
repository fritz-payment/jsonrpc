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

    protected $options = array();

    /**
     * Options:
     *
     * 'strictMode' => bool - if this option is present, any deviation from
     *                        the JSON RPC 2.0 specification will throw an exception
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Whether strict mode is enabled
     *
     * @return bool
     */
    public function isStrictMode() {
        return isset($this->options['strictMode']);
    }

    /**
     * @return Request
     */
    public function getRequest() {
        $req = new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Request();
        $req->setStrictMode($this->isStrictMode());
        return $req;
    }

    /**
     * @return Response
     */
    public function getResponse() {
        $resp = new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Response();
        $resp->setStrictMode($this->isStrictMode());
        return $resp;
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
