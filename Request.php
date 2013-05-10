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
abstract class Request
{
    /**
     * @var string
     */
    protected $method;
    protected $params = null;
    protected $id = null;
    /**
     * @var bool
     */
    protected $isNotification = false;
    protected $idSet = false;

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    abstract public function getVersion();

    /**
     * @param $method string
     *
     * @return Request
     */
    public function setMethod($method) {
        $this->method = (string)$method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param $isNotification
     *
     * @return Request
     */
    public function setIsNotification($isNotification) {
        $this->isNotification = $isNotification;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNotification() {
        return $this->isNotification;
    }

    /**
     * @param $id
     *
     * @return Request
     */
    public function setId($id) {
        $this->idSet = true;
        $this->id = $id;
        return $this;
    }

    /**
     * Return the json encoded request as a string. It is the request implementation's job
     * to ensure the correctness of the JSON string.
     *
     * @return string
     */
    abstract public function getRequestBody();
}
