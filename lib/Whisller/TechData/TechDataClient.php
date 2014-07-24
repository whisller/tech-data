<?php

namespace Whisller\TechData;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use JMS\Serializer\SerializerBuilder;
use Whisller\TechData\Components\OrderEnvComponent;

class TechDataClient
{
    private $httpClient;
    private $serializer;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->serializer = SerializerBuilder::create()->build();
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
