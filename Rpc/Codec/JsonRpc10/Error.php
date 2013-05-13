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
use FritzPayment\JsonRpc\Error as BaseError;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10;

class Error extends BaseError
{
    protected $error;

    public function __construct($error) {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return JsonRpc10::VERSION;
    }

    /**
     * @return string
     */
    public function error() {
        if (is_string($this->error)) {
            return $this->error;
        }
        return json_encode($this->error);
    }
}
