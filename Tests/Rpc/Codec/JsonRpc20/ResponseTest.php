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
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Response;
use FritzPayment\JsonRpc\Rpc\Codec\JsonRpc20\Error;
use FritzPayment\JsonRpc\Exception\ResponseException;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function provideResponses() {
        $res = array();
        $req = new Request();
        $req->setId('1');
        $res[] = array(
            $req,
            '{"result":["a"],"error":null,"id":"1"}',
            array('a')
        );
        $res[] = array(
            $req,
            '{"result":"b","error":null,"id":"1"}',
            'b'
        );
        $req   = new Request();
        $req->setIsNotification(true);
        $res[] = array(
            $req,
            '',
            null
        );
        return $res;
    }

    /**
     * @dataProvider provideResponses
     *
     * @param \FritzPayment\JsonRpc\Request $request
     * @param                               $responseBody
     * @param                               $expected
     */
    public function testCanCreateCorrectResults(\FritzPayment\JsonRpc\Request $request, $responseBody, $expected) {
        $resp = new Response();
        $resp->setRequest($request)
            ->setResponseBody($responseBody);
        $this->assertTrue($resp->parseResponse());
        $this->assertFalse($resp->isError());
        $this->assertEquals($expected, $resp->getResult());
    }

    public function testParseResponseWithoutIdThrowsException() {
        $req = new Request();
        $req->setId('1');
        $resp = new Response();
        $resp->setRequest($req)
            ->setResponseBody('{}');
        try {
            $resp->parseResponse();
        } catch (ResponseException $e) {
            $this->assertContains('missing id', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }

    public function testParseResponseWithMismatchedIdsThrowsException() {
        $req = new Request();
        $req->setId('1');
        $resp = new Response();
        $resp->setRequest($req)
            ->setResponseBody('{"id":"2"}');
        try {
            $resp->parseResponse();
        } catch (ResponseException $e) {
            $this->assertContains('id mismatch', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }

    public function testParseResponseWithResultAndErrorThrowsException() {
        $req = new Request();
        $req->setId('1');
        $resp = new Response();
        $resp->setRequest($req)
            ->setResponseBody('{"id":"1","error":"error","result":{}}');
        try {
            $resp->parseResponse();
        } catch (ResponseException $e) {
            $this->assertContains('must not exist', $e->getMessage());
            return;
        }
        $this->fail('Expecting exception.');
    }

    public function provideErrorResponses() {
        $res = array();
        $req = new Request();
        $req->setId('1');
        $res[] = array(
            $req,
            '{"result":null,"error":{"code":1,"message":"err"},"id":"1"}',
            '{"code":1,"message":"err"}'
        );
        $res[] = array(
            $req,
            '{"result":null,"error":{"code":2,"message":"err2","data":{"test":"test"}},"id":"1"}',
            '{"code":2,"message":"err2","data":{"test":"test"}}'
        );
        return $res;
    }

    /**
     * @dataProvider provideErrorResponses
     *
     * @param \FritzPayment\JsonRpc\Request $request
     * @param                               $responseBody
     * @param                               $expected
     */
    public function testResponseReturnsCorrectErrorObject(\FritzPayment\JsonRpc\Request $request, $responseBody, $expected) {
        $resp = new Response();
        $resp->setRequest($request)
            ->setResponseBody($responseBody);
        $this->assertFalse($resp->parseResponse());
        $this->assertTrue($resp->isError());
        $this->assertTrue($resp->getError() instanceof Error);
        $this->assertEquals($expected, $resp->getError()->error());
    }
}
