<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Body")
 */
class Body
{
    /**
     * @var Line
     *
     * @Serializer\Type("Whisller\TechData\Components\Line")
     * @Serializer\SerializedName("Line")
     */
    protected $line;

    public function __construct(Line $line)
    {
        $this->line = $line;
    }
}
