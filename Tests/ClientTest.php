<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests;
use FritzPayment\JsonRpc\Tests\ClientTest\CodecStub;
use FritzPayment\JsonRpc\Tests\ClientTest\TransportStub;
use FritzPayment\JsonRpc\Tests\ClientTest\RequestStub;
use FritzPayment\JsonRpc\Exception\CodecException;
use FritzPayment\JsonRpc\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $codec;
    protected $transport;
    /**
     * @var Client
     */
    protected $client;

    public function setUp() {
        $this->codec     = new CodecStub();
        $this->transport = new TransportStub();
        $this->client    = new Client('http://localhost', $this->codec, $this->transport);
    }

    public function testSendRequestWithIncompatibleCodecThrowsException() {
        $request = new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10\Request();
        try {
            $this->client->exec($request);
            $this->fail('Expecting exception on wrong codec.');
        } catch (CodecException $e) {
            $this->assertContains('Codec cannot handle request', $e->getMessage());
        }
    }

    public function testCreateRequestCreatesCorrectCodecRequest() {
        $request = $this->client->newRequest();
        $this->assertTrue($request instanceof RequestStub);
        $this->assertEquals('stub', $request->getVersion());
    }
}
