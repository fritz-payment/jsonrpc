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
use FritzPayment\JsonRpc\Request\RequestException;
use FritzPayment\JsonRpc\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * Returns the JSON RPC protocol version.
     *
     * @return string
     */
    public function getVersion() {
        return JsonRpc10::VERSION;
    }

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    protected function buildRequestArray() {
        $req = array();
        $req['method'] = $this->getMethod();
        $req['params'] = $this->params;
        if (!$this->isNotification()) {
            if (!$this->idSet) {
                throw new RequestException('Request is not a notification, but no id set.');
            }
            if ($this->id === null) {
                throw new RequestException('NULL id is indistinguishable from notification request.');
            }
            $req['id'] = $this->id;
        } else {
            // JSON RPC 1.0 requires id to be NULL for notifications
            // This is a little inconsistency in the spec since this won't allow NULL ids\
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
        return json_encode($this->buildRequestArray(), JSON_FORCE_OBJECT);
    }
}
