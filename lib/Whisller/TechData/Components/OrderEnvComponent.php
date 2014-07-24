<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("OrderEnv")
 */
class OrderEnvComponent
{
    /**
     * @Serializer\XmlList(inline = true, entry = "Order")
     */
    protected $orders;

    public function addOrder(OrderComponent $order)
    {
        $this->orders[] = $order;
    }
} 
