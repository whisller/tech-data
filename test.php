<?php

include './vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Client;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\XmlDeserializationVisitor;

AnnotationRegistry::registerLoader('class_exists');

/**
 * START: Prepare Serializer
 */
$xmlVisitor = new XmlDeserializationVisitor(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()));
$xmlVisitor->setDoctypeWhitelist(
    [
        '<!DOCTYPE XGResponse SYSTEM "http://intcom.xml.techdata-europe.com:8080/XMLGate/XMLGateResponse.dtd">'
    ]
);
$serializer = \JMS\Serializer\SerializerBuilder::create()->addDefaultSerializationVisitors()->setDeserializationVisitor('tech_data', $xmlVisitor)->build();
/**
 * STOP
 */

/**
 * START: Create Tech Data models
 */
$orderEnv = new \Whisller\TechData\Components\OrderEnvComponent('my-auth-code', 1);
$deliver = new \Whisller\TechData\Components\DeliverToComponent();
$address = new \Whisller\TechData\Components\AddressComponent('69, Flat X', 'Nice Street', 'Nibylandia', 'UK');
$deliver->setAddress($address);
$head = new \Whisller\TechData\Components\HeadComponent(
    'my title',
    new DateTime('now', new DateTimeZone('Europe/London')),
    $deliver
);
$line = new \Whisller\TechData\Components\LineComponent(1, 123, 55, [new \Whisller\TechData\Components\AddItemID('EAN', 'my-ean')]);
$body = new \Whisller\TechData\Components\BodyComponent($line);
$order = new \Whisller\TechData\Components\OrderComponent('GBP', $head, $body);
$orderEnv->addOrder($order);
/**
 * STOP
 */

/**
 * START: Send data to Tech Data
 */
$techDataApiClient = new \Whisller\TechData\TechDataClient(new Client(), $serializer, new \Whisller\TechData\TechDataValidator(), 'https://intcom.xml.techdata-europe.com:443/');
$response = $techDataApiClient->sendOrders($orderEnv);
/**
 * STOP
 */

/**
 * START: Transform response
 */
$transformToObject = new \Whisller\TechData\Transformers\TransformerToObject($serializer);
var_dump($transformToObject->transform((string) $response->getBody()));
/**
 * STOP
 */

