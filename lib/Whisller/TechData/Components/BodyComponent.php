<?php

namespace Whisller\TechData\Components;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("Body")
 */
class BodyComponent implements ComponentInterface
{
    /**
     * @var LineComponent
     *
     * @Serializer\Type("Whisller\TechData\Components\LineComponent")
     * @Serializer\SerializedName("Line")
     */
    protected $line;

    public function __construct(LineComponent $line)
    {
        $this->line = $line;
    }
}
