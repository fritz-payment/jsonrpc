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
use FritzPayment\JsonRpc\Rpc\Codec;
use FritzPayment\JsonRpc\Client\Transport;

class Client
{
    /**
     * @var string
     */
    protected $url;
    /**
     * @var Rpc\Codec
     */
    protected $codec;
    /**
     * @var Client\Transport
     */
    protected $transport;

    public function __construct($url, Codec $codec, Transport $transport) {
        $this->url       = $url;
        $this->codec     = $codec;
        $this->transport = $transport;
    }
}
