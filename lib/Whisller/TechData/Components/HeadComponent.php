<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Head")
 */
class HeadComponent
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Title")
     */
    protected $title;
    /**
     * @Serializer\Type("DateTime<'Ymd'>")
     * @Serializer\SerializedName("OrderDate")
     */
    protected $orderDate;

    public function __construct($title, $orderDate)
    {
        $this->title = $title;
        $this->orderDate = $orderDate;
    }
} 
