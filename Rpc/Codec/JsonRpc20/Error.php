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
use FritzPayment\JsonRpc\Error as BaseError;
use FritzPayment\JsonRpc\Exception\ResponseException;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20;

class Error extends BaseError
{
    const PARSE_ERROR = -32700;
    const INVALID_REQUEST = -32600;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;
    const INTERNAL_ERROR = -32603;

    protected $error;

    public function __construct(\stdClass $error) {
        $this->error = $error;
        if (!isset($this->error->code)) {
            throw new ResponseException('Response error without error code.');
        }
        if (!is_int($this->error->code)) {
            throw new ResponseException('Response error code MUST be an integer.');
        }
        if (!isset($this->error->message)) {
            throw new ResponseException('Response error without error message.');
        }
    }

    /**
     * @return int
     */
    public function getCode() {
        return $this->error->code;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return (string)$this->error->message;
    }

    /**
     * @return mixed
     */
    public function getData() {
        if (!isset($this->error->data)) {
            return null;
        }
        return $this->error->data;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return JsonRpc20::VERSION;
    }

    /**
     * @return string
     */
    public function error() {
        return json_encode($this->error);
    }
}
