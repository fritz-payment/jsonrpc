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
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10\Error;
use FritzPayment\JsonRpc\Exception\ResponseException;

class Response extends BaseResponse
{
    protected $responseJson;
    protected $result;

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc10::VERSION;
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
     * The concrete implementation should always check for the correctness
     * of the JSON structure.
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
            throw new ResponseException('Could not parse JSON: ' . $this->jsonLastError);
        }
        if (!isset($this->request)) {
            throw new ResponseException('Implementation error. Missing request object.');
        }
        if (!$this->request->isNotification()) {
            if (!isset($this->responseJson->id) || $this->responseJson->id != $this->request->getId()) {
                throw new ResponseException('Request was not a notification, but missing id.');
            }
        }
        if (isset($this->responseJson->error) && $this->responseJson->error !== null) {
            // result must be null if there was an error
            if ($this->responseJson->result !== null) {
                throw new ResponseException('Result must be null if error.');
            }
            $this->error = new Error($this->responseJson->error);
            return false;
        }
        $this->result = $this->responseJson->result;
        return true;
    }
}
