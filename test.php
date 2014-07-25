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
 * START: Create Tech Data models
 */
$orderEnv = new \Whisller\TechData\Components\OrderEnvComponent();
$head = new \Whisller\TechData\Components\HeadComponent(
    'my title',
    new DateTime('now', new DateTimeZone('Europe/London'))
);
$line = new \Whisller\TechData\Components\LineComponent(1, 123, 55);
$body = new \Whisller\TechData\Components\BodyComponent($line);
$order = new \Whisller\TechData\Components\OrderComponent('GBP', $head, $body);
$orderEnv->addOrder($order);
/**
 * STOP
 */

$xmlVisitor = new XmlDeserializationVisitor(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()));
$xmlVisitor->setDoctypeWhitelist(
    [
        '<!DOCTYPE XGResponse SYSTEM "http://intcom.xml.techdata-europe.com:8080/XMLGate/XMLGateResponse.dtd">'
    ]
);
$serializer = \JMS\Serializer\SerializerBuilder::create()->addDefaultSerializationVisitors()->setDeserializationVisitor('tech_data', $xmlVisitor)->build();

$dtdValidator = new \Whisller\TechData\TechDataDTDValidator();
$transormerToXml = new \Whisller\TechData\Transformers\TransformerToXml($serializer, $dtdValidator);

$xml = $transormerToXml->transform($orderEnv);

$techDataApiClient = new \Whisller\TechData\TechDataClient(new Client(), $serializer);
$techDataApiClient->sendOrders($xml);

$serializer->serialize($orderEnv, 'xml');
