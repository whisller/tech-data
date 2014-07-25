<?php

namespace Whisller\TechData;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use JMS\Serializer\SerializerInterface;

class TechDataClient
{
    protected $httpClient;
    protected $serializer;
    protected $mode;

    public function __construct(ClientInterface $client, SerializerInterface $serializer, $mode = 'test')
    {
        $this->httpClient = $client;
        $this->serializer = $serializer;
        $this->mode = $mode;
    }

    public function sendOrders($xml)
    {
        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.techdata-europe.com:443/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $xml,
                ]
            ]
        );

        return $response;
    }
}
