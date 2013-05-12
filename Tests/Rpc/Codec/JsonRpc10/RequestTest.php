<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Tests\Rpc\Codec\JsonRpc10;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10\Request;
use FritzPayment\JsonRpc\Exception\RequestException;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function provideRequestEncodings() {
        return array(
            array(
                'test',
                array('test', 1, array('dd' => 'ee')),
                1,
                '{"method":"test","params":["test",1,{"dd":"ee"}],"id":1}'
            ),
            array(
                'System.Echo',
                array(array('Msg' => 'test')),
                'dde',
                '{"method":"System.Echo","params":[{"Msg":"test"}],"id":"dde"}'
            ),
            array(
                'System.Echo',
                array(array('Msg' => 'test', 'Msg2' => 'test2')),
                1,
                '{"method":"System.Echo","params":[{"Msg":"test","Msg2":"test2"}],"id":1}'
            ),
        );
    }

    /**
     * @dataProvider provideRequestEncodings
     *
     * @param $method string
     * @param $params mixed
     * @param $id mixed
     * @param $expected string
     */
    public function testRequestCorrectlyEncodes($method, $params, $id, $expected) {
        $request = new Request();
        $request->setMethod($method)
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

        $expect = '{"method":"test","params":[],"id":"1"}';
        $this->assertEquals($expect, $request->getRequestBody());
    }

    public function testGetRequestBodyWithoutMethodThrowsException() {
        $request = new Request();
        try {
            $request->getRequestBody();
            $this->fail('Expecting exception.');
        } catch (RequestException $e) {
            $this->assertContains('no method set', $e->getMessage());
        }
    }

    public function testNotNotificationWithoutIdThrowsException() {
        $request = new Request();
        $request->setMethod('test');
        try {
            $request->getRequestBody();
            $this->fail('Expecting exception.');
        } catch (RequestException $e) {
            $this->assertContains('no id set', $e->getMessage());
        }
    }

    public function testNotNotificationWithNullIdThrowsException() {
        $request = new Request;
        $request->setMethod('test')
            ->setIsNotification(false)
            ->setId(null);
        try {
            $request->getRequestBody();
            $this->fail('Expecting exception.');
        } catch (RequestException $e) {
            $this->assertContains('NULL id', $e->getMessage());
        }
    }
}
