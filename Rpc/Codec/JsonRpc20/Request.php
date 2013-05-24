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
use FritzPayment\JsonRpc\Exception\RequestException;
use FritzPayment\JsonRpc\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc20::VERSION;
    }

    public function setMethod($method) {
        if (mb_strpos($method, 'rpc.') === 0) {
            throw new RequestException('Invalid use of reserved method name.');
        }
        return parent::setMethod($method);
    }

    /**
     * Set request params.
     * If params are set, it must be an array, since the spec requires a structured
     * value.
     * If this method is never called, the param member is NULL. In this case the
     * param member will be omitted.
     *
     * @param array $params
     *
     * @return Request
     */
    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    protected function buildRequestArray() {
        $req = array();
        if ($this->getMethod() === null || !$this->getMethod()) {
            throw new RequestException('Invalid method or no method set.');
        }
        // jsonrpc member required
        $req['jsonrpc'] = JsonRpc20::VERSION;
        $req['method'] = $this->getMethod();
        if ($this->params !== null) {
            $req['params'] = $this->params;
        }
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
        }
        return $req;
    }

    /**
     * Return the json encoded request as a string.
     *
     * @return string
     */
    public function getRequestBody() {
        return json_encode($this->buildRequestArray());
    }
}
