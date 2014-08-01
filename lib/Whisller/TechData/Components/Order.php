<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Order")
 */
class Order
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
     * @var Head
     *
     * @Serializer\Type("Whisller\TechData\Components\Head")
     * @Serializer\SerializedName("Head")
     * @Serializer\XmlElement
     */
    protected $head;
    /**
     * @var Body
     *
     * @Serializer\Type("Whisller\TechData\Components\Body")
     * @Serializer\SerializedName("Body")
     */
    protected $body;

    public function __construct($currency, Head $head, Body $body)
    {
        $this->currency = $currency;
        $this->head = $head;
        $this->body = $body;
    }
}
