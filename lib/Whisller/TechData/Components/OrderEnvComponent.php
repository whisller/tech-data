<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("OrderEnv")
 */
class OrderEnvComponent implements ComponentInterface
{
    /**
     * @Serializer\XmlAttribute
     * @Serializer\Type("string")
     * @Serializer\SerializedName("AuthCode")
     */
    protected $authCode;
    /**
     * @Serializer\XmlAttribute
     * @Serializer\Type("string")
     * @Serializer\SerializedName("MsgID")
     */
    protected $msgId;
    /**
     * @Serializer\Type("array<Whisller\TechData\Components\OrderComponent>")
     * @Serializer\XmlList(inline = true, entry = "Order")
     */
    protected $orders;

    public function __construct($authCode, $msgId)
    {
        $this->authCode = $authCode;
        $this->msgId = $msgId;
    }

    public function addOrder(OrderComponent $order)
    {
        $this->orders[] = $order;
    }
}
