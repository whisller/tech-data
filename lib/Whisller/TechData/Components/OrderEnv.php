<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

class OrderEnv
{
    /**
     * @Serializer\Type("ArrayCollection<Whisller\TechData\Components\Order>")
     */
    private $orders;

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }
} 
