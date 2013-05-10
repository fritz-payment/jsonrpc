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
use FritzPayment\JsonRpc\Client;
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSendRequestWithIncompatibleCodecThrowsException() {
        $codec = new \FritzPayment\JsonRpc\Tests\ClientTest\CodecStub();
        $transport = new \FritzPayment\JsonRpc\Tests\ClientTest\TransportStub();
        $client = new Client('http://localhost', $codec, $transport);
        $request = new \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10\Request();
        try {
            $client->exec($request);
            $this->fail('Expecting exception on wrong codec.');
        } catch (\FritzPayment\JsonRpc\Rpc\Codec\Exception $e) {
            $this->assertContains('Codec cannot handle request', $e->getMessage());
        }
    }
}
