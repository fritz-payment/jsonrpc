<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20;
use FritzPayment\JsonRpc\Response as BaseResponse;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Error;
use FritzPayment\JsonRpc\Exception\ResponseException;

class Response extends BaseResponse
{
    protected $strictMode = false;
    protected $responseJson;
    protected $result;

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc20::VERSION;
    }

    /**
     * @param $strict bool
     *
     * @return Response
     */
    public function setStrictMode($strict) {
        $this->strictMode = (bool)$strict;
        return $this;
    }

    /**
     * @return \stdClass|array
     */
    public function getResult() {
        if (!isset($this->result)) {
            return null;
        }
        return $this->result;
    }

    /**
     * Will be called by the client. This method should take the raw response body and
     * create the applicable result objects.
     *
     * @return bool
     * @throws \FritzPayment\JsonRpc\Exception\ResponseException
     */
    public function parseResponse() {
        if ($this->request->isNotification()) {
            // notification has no response body
            $this->result = null;
            return true;
        }

        if (!$this->parseResponseBody()) {
            $e = new ResponseException('Could not parse JSON: ' . $this->jsonLastError);
            $e->setResponseBody($this->responseBody);
            throw $e;
        }
        if (!isset($this->request)) {
            throw new ResponseException('Implementation error. Missing request object.');
        }
        if (isset($this->responseJson->error) && $this->responseJson->error !== null) {
            // result must not exist if there was an error
            if ($this->strictMode && isset($this->responseJson->result)) {
                throw new ResponseException('Result must not exist if error.');
            }
            if (!$this->responseJson->error instanceof \stdClass) {
                throw new ResponseException('Error object type error.');
            }
            $this->error = new Error($this->responseJson->error);
            return false;
        }
        if (!$this->request->isNotification()) {
            if (!isset($this->responseJson->id)) {
                throw new ResponseException('Request was not a notification, but missing id.');
            }
            if ($this->responseJson->id != $this->request->getId()) {
                throw new ResponseException('Request/response id mismatch.');
            }
        }
        $this->result = $this->responseJson->result;
        return true;
    }
}
