<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Line")
 */
class LineComponent
{
    /**
     * @var int
     *
     * @Serializer\XmlAttribute
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("ID")
     */
    private $id;
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("ItemID")
     */
    private $itemId;
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("Qty")
     */
    private $quantity;

    public function __construct($id, $itemId, $quantity)
    {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->quantity = $quantity;
    }
} 
