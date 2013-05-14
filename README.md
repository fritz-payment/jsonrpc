jsonrpc
=======

A general JSON RPC implementation.

* Support for different transports (currently a cURL implementation exists).
* Different JSON RPC Codecs (currently JSON RPC Version 1.0 as defined by http://json-rpc.org/wiki/specification is implemented; JSON RPC 2.0 http://www.jsonrpc.org/specification will be supported soon).
* Clean API.

# What's new

## Version 0.1.0

* Finished basic implementations.

We will start working on the JSON RPC 2.0 Codec now.

# Getting started

## Installation

You can use Composer (http://www.getcomposer.org) to install the JSON RPC library.

    {
        "require": {
            "fritz-payment/jsonrpc": "dev-master"
        }
    }

## Usage

This example calls a JSON RPC 1.0 method "test.echo" on the URL http://www.example.com using cURL.

    <?php
    use \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10;
    use \FritzPayment\JsonRpc\Client\Transport\Curl;

    // initialize JSON RPC 1.0 Codec
    $codec = new JsonRpc10();
    // initialize cURL transport
    $transport = new Curl();

    // initialize client
    $client = new \FritzPayment\JsonRpc\Client('http://www.example.com', $codec, $transport);

    // create a new request
    /* @var $request \FritzPayment\JsonRpc\Rpc\Codec\JsonRpc10\Request */
    $request = $client->newRequest();
    $request->setMethod('test.echo')
        ->setId('1');
    $request->setParams(array('test message'));

    // send request
    $response = $client->exec($request);
    if ($response === false) {
        // failed
    } else {
        if ($response->isError()) {
            // JSON RPC error
            echo $response->getError()->error();
        } else {
            var_dump($response->getResult());
        }
    }

## Extending the library

It is possible to create your own implementations of Transports and Codecs.

The abstract Transport and Codec classes and the existing implementations should give you an idea of how to do that.
