<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Client\Transport;
use FritzPayment\JsonRpc\Request;
use FritzPayment\JsonRpc\Rpc\Codec;
use FritzPayment\JsonRpc\Client\Transport;
use FritzPayment\JsonRpc\Exception\TransportException;

class Curl implements Transport
{
    protected $url;
    protected $httpMethod = 'POST';
    protected $curlOptions = array();
    protected $headers = array();
    protected $errorNo;
    protected $errorMsg;

    public function setCurlOptions(array $options) {
        $this->curlOptions = $options;
        return $this;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Add HTTP headers in the form key => value
     *
     * @param array $headers
     */
    public function addHeaders(array $headers) {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * @return array
     */
    protected function buildHeaders() {
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $headers;
    }

    /**
     * @param $url
     *
     * @return bool
     */
    public function setUrl($url) {
        $this->url = $url;
        return true;
    }

    /**
     * @return array
     */
    protected function createCurlOptions() {
        $options                         = $this->curlOptions;
        $options[CURLOPT_URL]            = $this->url;
        $options[CURLOPT_HTTPHEADER]     = $this->buildHeaders();
        $options[CURLOPT_RETURNTRANSFER] = true;
        // method
        switch ($this->httpMethod) {
            case 'GET':
                $options[CURLOPT_HTTPGET] = true;
                break;
            case 'POST':
            default:
                $options[CURLOPT_POST] = true;
                break;
        }
        return $options;
    }

    /**
     * @param \FritzPayment\JsonRpc\Request $request
     *
     * @return string|void
     * @throws \FritzPayment\JsonRpc\Exception\TransportException
     */
    public function send(Request $request) {
        // TODO: Implement send() method.
        $ch = curl_init();
        if ($ch === false) {
            throw new TransportException('Could not initialize cURL handle.');
        }
        if (!curl_setopt_array($ch, $this->createCurlOptions())) {
            throw new TransportException('Could not initialize cURL options.');
        }
        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $this->errorNo  = curl_errno($ch);
            $this->errorMsg = curl_error($ch);
        }
        curl_close($ch);
        return $responseBody;
    }

    /**
     * @return int
     */
    public function getErrorCode() {
        return $this->errorNo;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMsg;
    }
}
