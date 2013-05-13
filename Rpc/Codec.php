<?php
/*
 * This file is part of the Fritz Payment JSON RPC package.
 *
 * (c) Fritz Payment GmbH <info@fritz-payment.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FritzPayment\JsonRpc\Rpc;
use FritzPayment\JsonRpc\Request;
use FritzPayment\JsonRpc\Response;
use FritzPayment\JsonRpc\Error;

interface Codec
{
    /**
     * @return Request
     */
    public function getRequest();

    /**
     * @return Response
     */
    public function getResponse();

    /**
     * @param \FritzPayment\JsonRpc\Request $request
     *
     * @return bool
     */
    public function isCodecRequest(Request $request);

    /**
     * @param \FritzPayment\JsonRpc\Response $response
     *
     * @return bool
     */
    public function isCodecResponse(Response $response);

    /**
     * @param \FritzPayment\JsonRpc\Error $error
     *
     * @return bool
     */
    public function isCodecError(Error $error);
}
