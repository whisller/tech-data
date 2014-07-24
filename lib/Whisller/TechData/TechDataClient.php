<?php

namespace Whisller\TechData;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use JMS\Serializer\SerializerInterface;
use Whisller\TechData\Components\OrderEnvComponent;

class TechDataClient
{
    protected $httpClient;
    protected $serializer;

    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->httpClient = $client;
        $this->serializer = $serializer;
    }

    public function sendOrders(OrderEnvComponent $orderEnv)
    {
        /** @var Response $response */
        $response = $this->httpClient->post(
            'https://intcom.xml.quality.techdata.de/XMLGate/inbound',
            [
                'body' => [
                    'xmlmsg' => $this->serializer->serialize($orderEnv, 'xml'),
                ]
            ]
        );

        var_dump((string) $response->getBody());
    }
}
