<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests\Rpc\Codec\JsonRpc20;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Request;
use FritzPayment\JsonRpc\Exception\RequestException;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provide test fixtures for testRequestCorrectlyEncodes()
     * @return array
     */
    public function provideRequestEncodings() {
        return array(
            array(
                'test',
                array('test', 1, array('dd' => 'ee')),
                false,
                1,
                '{"jsonrpc":"2.0","method":"test","params":["test",1,{"dd":"ee"}],"id":1}'
            ),
            array(
                'System.Echo',
                array('Msg' => 'test'),
                false,
                'dde',
                '{"jsonrpc":"2.0","method":"System.Echo","params":{"Msg":"test"},"id":"dde"}'
            ),
            array(
                'System.Echo',
                array('Msg' => 'test', 'Msg2' => 'test2'),
                true,
                null,
                '{"jsonrpc":"2.0","method":"System.Echo","params":{"Msg":"test","Msg2":"test2"}}'
            ),
        );
    }

    /**
     * @dataProvider provideRequestEncodings
     *
     * @param $method string
     * @param $params mixed
     * @param $isNotification bool
     * @param $id mixed
     * @param $expected string
     */
    public function testRequestCorrectlyEncodes($method, $params, $isNotification, $id, $expected) {
        $request = new Request();
        $request->setMethod($method)
            ->setIsNotification($isNotification)
            ->setId($id);
        $request->setParams($params);
        $this->assertEquals($expected, $request->getRequestBody());
    }

    public function testRequestHasCorrectDefaultValues() {
        $request = new Request();
        $this->assertFalse($request->isNotification());
        $this->assertNull($request->getMethod());

        $request->setMethod('test');
        $request->setId('1');
        $this->assertFalse($request->isNotification());
        // explicitly set notification type, but id present
        // implies: no notification
        $request->setIsNotification(true);
        $this->assertFalse($request->isNotification());

        $expect = '{"jsonrpc":"2.0","method":"test","id":"1"}';
        $this->assertEquals($expect, $request->getRequestBody());
    }

    public function testGetRequestBodyWithoutMethodThrowsException() {
        $request = new Request();
        try {
            $request->getRequestBody();
        } catch (RequestException $e) {
            $this->assertContains('no method set', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }

    public function testNotNotificationWithoutIdThrowsException() {
        $request = new Request();
        $request->setMethod('test');
        try {
            $request->getRequestBody();
        } catch (RequestException $e) {
            $this->assertContains('no id set', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }

    public function testNotNotificationWithNullIdThrowsException() {
        $request = new Request;
        $request->setMethod('test')
            ->setIsNotification(false)
            ->setId(null);
        try {
            $request->getRequestBody();
        } catch (RequestException $e) {
            $this->assertContains('NULL id', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }
}
