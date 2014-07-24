<?php

include './vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader('class_exists');

$orderEnv = new \Whisller\TechData\Components\OrderEnvComponent();
$head = new \Whisller\TechData\Components\HeadComponent('my title', new DateTime('now', new DateTimeZone('Europe/London')));
$line = new \Whisller\TechData\Components\LineComponent(1, 123, 55);
$body = new \Whisller\TechData\Components\BodyComponent($line);
$order = new \Whisller\TechData\Components\OrderComponent('GBP', $head, $body);
$orderEnv->addOrder($order);

$serializer = \JMS\Serializer\SerializerBuilder::create()->build();

$httpClient = new \Whisller\TechData\TechDataClient();
$httpClient->sendOrders($orderEnv);

//echo $serializer->serialize($orderEnv, 'xml');
