<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Order")
 */
class OrderComponent
{
    /**
     * @var string
     *
     * @Serializer\XmlAttribute
     */
    private $currency;
    /**
     * @var HeadComponent
     *
     * @Serializer\Type("Whisller\TechData\Components\HeadComponent")
     * @Serializer\SerializedName("Head")
     */
    private $head;
    /**
     * @var BodyComponent
     *
     * @Serializer\Type("Whisller\TechData\Components\BodyComponent")
     * @Serializer\SerializedName("Body")
     */
    private $body;

    public function __construct($currency, HeadComponent $head, BodyComponent $body)
    {
        $this->currency = $currency;
        $this->head = $head;
        $this->body = $body;
    }
}
