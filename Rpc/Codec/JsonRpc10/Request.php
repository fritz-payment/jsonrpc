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
use FritzPayment\JsonRpc\Exception\RequestException;
use FritzPayment\JsonRpc\Request as BaseRequest;

class Request extends BaseRequest
{
    public function __construct() {
        // initialize empty params
        $this->params = array();
    }

    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc10::VERSION;
    }

    /**
     * Set request params.
     * Since the specs require the params to be an actual array in JSON,
     * this method will only take the values of the passed array
     * and store it in an indexed array.
     *
     * @param array $params
     *
     * @return Request
     */
    public function setParams(array $params) {
        // specification requires params to be an indexed array in PHP
        $this->params = array_values($params);
        return $this;
    }

    protected function buildRequestArray() {
        $req = array();
        if ($this->getMethod() === null || !$this->getMethod()) {
            throw new RequestException('Invalid method or no method set.');
        }
        $req['method'] = $this->getMethod();
        $req['params'] = $this->params;
        if (!$this->isNotification()) {
            if (!$this->idSet) {
                throw new RequestException('Request is not a notification, but no id set.');
            }
            if ($this->id === null) {
                // No notification but NULL id. This is almost never intended.
                // That's why we throw an exception here
                throw new RequestException('NULL id is indistinguishable from notification request.');
            }
            $req['id'] = $this->id;
        } else {
            // JSON RPC 1.0 requires id to be NULL for notifications
            // This is a little inconsistency in the spec since this won't allow NULL ids
            // Also see exception above
            $req['id'] = null;
        }
        return $req;
    }

    /**
     * Return the json encoded request as a string. It is the request implementation's job
     * to ensure the correctness of the JSON string.
     *
     * @return string
     */
    public function getRequestBody() {
        return json_encode($this->buildRequestArray());
    }
}
