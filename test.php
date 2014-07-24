<?php
//
//include 'vendor/autoload.php';
//
//use Whisller\TechData\TechDataBuilder;
//
//$builder = new TechDataBuilder('https://integratex.quality.techdata.de:443/ix/dtd/ixOrder4.dtd', 123456, 1);
//
//// 1.
//$builder
//    ->add('GBP')
//        ->addHead()
//            ->setTitle('MyPO')
//            ->setOrderDate('20071210')
//            ->setDelivery('XY') // from where get type
//        ->end()
//        ->addBody()
//            ->addLine(1)
//                ->setItemId(1590150)
//                ->setQty(19)
//            ->end()
//        ->end()
//    ->end();
//
//// 3.
//$order = new OrderComponent($builder->getXml(), 'GBP');
//$head = new HeadComponent($order->getXml(), 'Title', 'order-date', 'delivery');
//$order->add($head);
//
//$builder->add($order);
//
//
//
//echo $builder;

include './vendor/autoload.php';

$orderEnv = new \Whisller\TechData\Components\OrderEnv();
$orderEnv->addOrder(new \Whisller\TechData\Components\Order());

$serializer = \JMS\Serializer\SerializerBuilder::create()->build();
echo $serializer->serialize($orderEnv, 'xml');
