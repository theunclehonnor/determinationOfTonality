<?php


namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class ResourceDTO
{
    /**
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Type("string")
     */
    private $link;

    public function getName()
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }
}
