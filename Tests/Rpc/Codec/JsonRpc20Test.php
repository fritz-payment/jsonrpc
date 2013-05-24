<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests\Rpc\Codec;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20;

class JsonRpc20Test extends \PHPUnit_Framework_TestCase
{
    public function testCodecCreatesCorrectInstances() {
        $codec    = new JsonRpc20();
        $request  = $codec->getRequest();
        $response = $codec->getResponse();
        $this->assertTrue($codec->isCodecRequest($request));
        $this->assertTrue($codec->isCodecResponse($response));
    }

    public function testCodecDetectsWrongInstances() {
        $codec    = new JsonRpc20();
        $request  = new \FritzPayment\JsonRpc\Tests\ClientTest\RequestStub();
        $response = new \FritzPayment\JsonRpc\Tests\ClientTest\ResponseStub();
        $this->assertFalse($codec->isCodecRequest($request));
        $this->assertFalse($codec->isCodecResponse($response));
    }
}
