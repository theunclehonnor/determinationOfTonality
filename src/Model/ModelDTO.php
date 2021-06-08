<?php

namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class ModelDTO
{
    /**
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Type("string")
     */
    private $dataSet;

    /**
     * @Serializer\Type("string")
     */
    private $classificator;

    /**
     * @Serializer\Type("string")
     */
    private $description;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDataSet()
    {
        return $this->dataSet;
    }

    public function setDataSet(string $dataSet): void
    {
        $this->dataSet = $dataSet;
    }

    public function getClassificator()
    {
        return $this->classificator;
    }

    public function setClassificator(string $classificator): void
    {
        $this->classificator = $classificator;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
