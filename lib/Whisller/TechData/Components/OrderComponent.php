<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Order")
 */
class OrderComponent implements ComponentInterface
{
    /**
     * @var string
     *
     * @Serializer\XmlAttribute
     * @Serializer\Type("string")
     * @Serializer\SerializedName("Currency")
     */
    protected $currency;
    /**
     * @var HeadComponent
     *
     * @Serializer\Type("Whisller\TechData\Components\HeadComponent")
     * @Serializer\SerializedName("Head")
     * @Serializer\XmlElement
     */
    protected $head;
    /**
     * @var BodyComponent
     *
     * @Serializer\Type("Whisller\TechData\Components\BodyComponent")
     * @Serializer\SerializedName("Body")
     */
    protected $body;

    public function __construct($currency, HeadComponent $head, BodyComponent $body)
    {
        $this->currency = $currency;
        $this->head = $head;
        $this->body = $body;
    }
}
