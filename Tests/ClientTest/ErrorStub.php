<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests\ClientTest;
use FritzPayment\JsonRpc\Error;

class ErrorStub extends Error
{
    protected $error;

    public function __construct($error) {
        $this->error = (string)$error;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return 'stub';
    }

    /**
     * @return string
     */
    public function error() {
        return $this->error;
    }
}
