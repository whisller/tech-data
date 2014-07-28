<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Line")
 */
class LineComponent implements ComponentInterface
{
    /**
     * @var int
     *
     * @Serializer\XmlAttribute
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("ID")
     */
    protected $id;
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("ItemID")
     */
    protected $itemId;
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("Qty")
     */
    protected $quantity;

    /**
     * @Serializer\Type("array<Whisller\TechData\Components\AddItemID>")
     * @Serializer\XmlList(inline = true, entry = "AddItemID")
     */
    protected $addItemIds;

    public function __construct($id, $itemId, $quantity, array $addItemIds = [])
    {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->quantity = $quantity;
        $this->addItemIds = $addItemIds;
    }
}
