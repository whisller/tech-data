<?php

include './vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Client;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\XmlDeserializationVisitor;

AnnotationRegistry::registerLoader('class_exists');

$orderEnv = new \Whisller\TechData\Components\OrderEnvComponent();
$head = new \Whisller\TechData\Components\HeadComponent(
    'my title',
    new DateTime('now', new DateTimeZone('Europe/London'))
);
$line = new \Whisller\TechData\Components\LineComponent(1, 123, 55);
$body = new \Whisller\TechData\Components\BodyComponent($line);
$order = new \Whisller\TechData\Components\OrderComponent('GBP', $head, $body);
$orderEnv->addOrder($order);

$xmlVisitor = new XmlDeserializationVisitor(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()));
$xmlVisitor->setDoctypeWhitelist(
    [
        '<!DOCTYPE XGResponse SYSTEM "http://intcom.xml.quality.techdata.de:8080/XMLGate/XMLGateResponse.dtd">'
    ]
);
$serializer = \JMS\Serializer\SerializerBuilder::create()->addDefaultSerializationVisitors()->setDeserializationVisitor('xml', $xmlVisitor)->build();

//var_dump($serializer->deserialize('
//<OrderEnv>
//  <Order currency="GBP">
//    <Head>
//      <Title><![CDATA[my title]]></Title>
//      <OrderDate><![CDATA[20140724]]></OrderDate>
//    </Head>
//    <Body>
//      <Line ID="1">
//        <ItemID>123</ItemID>
//        <Qty>55</Qty>
//      </Line>
//    </Body>
//  </Order>
//</OrderEnv>', 'Whisller\TechData\Components\OrderEnvComponent', 'xml'));


$techDataApiClient = new \Whisller\TechData\TechDataClient(new Client(), $serializer);
$techDataApiClient->sendOrders($orderEnv);

//echo $serializer->serialize($orderEnv, 'xml');
