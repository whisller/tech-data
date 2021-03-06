<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Head")
 */
class Head
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
    /**
     * @Serializer\Type("Whisller\TechData\Components\DeliverTo")
     * @Serializer\SerializedName("DeliverTo")
     */
    protected $deliver;


    public function __construct($title, $orderDate, $deliver)
    {
        $this->title = $title;
        $this->orderDate = $orderDate;
        $this->deliver = $deliver;
    }
}
