<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc;
/**
 * A JSON RPC response.
 *
 * A transport will call the setResponseBody() method to pass the raw response string.
 * It is the responsibility of the response implementations to parse/create the applicable
 * JSON RPC id, result and error objects.
 */
abstract class Response
{
    /**
     * @var mixed
     */
    protected $id;
    /**
     * @var string
     */
    protected $responseBody;
    /**
     * @var Error
     */
    protected $error = null;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    abstract public function getVersion();

    /**
     * Called by client. Pass the raw body to the response
     *
     * @param $responseBody
     *
     * @return Response
     */
    public function setResponseBody($responseBody) {
        $this->responseBody = $responseBody;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function getResultString();

    /**
     * @return \stdClass|array
     */
    abstract public function getResultJson();

    /**
     * @return bool
     */
    public function isError() {
        return $this->error !== null;
    }

    /**
     * @return Error|null
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Will be called by the client. This method should take the raw response body and
     * create the applicable result objects.
     *
     * @return bool
     */
    abstract public function parseResponse();
}
