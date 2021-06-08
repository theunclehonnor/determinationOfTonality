<?php


namespace App\Model;


use JMS\Serializer\Annotation as Serializer;

class AnalyzeDTO
{
    /**
     * @var ?ResourceDTO
     * @Serializer\Type("App\Model\ResourceDTO")
     */
    private $resource;

    /**
     * @var ?ObjectInQuestionDTO
     * @Serializer\Type("App\Model\ObjectInQuestionDTO")
     */
    private $objectInQuestion;

    /**
     * @var ?ModelDTO
     * @Serializer\Type("App\Model\ModelDTO")
     */
    private $model;

    /**
     * @return ResourceDTO|null
     */
    public function getResource(): ?ResourceDTO
    {
        return $this->resource;
    }

    /**
     * @param ResourceDTO|null $resource
     */
    public function setResource(?ResourceDTO $resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return ObjectInQuestionDTO|null
     */
    public function getObjectInQuestion(): ?ObjectInQuestionDTO
    {
        return $this->objectInQuestion;
    }

    /**
     * @param ObjectInQuestionDTO|null $objectInQuestion
     */
    public function setObjectInQuestion(?ObjectInQuestionDTO $objectInQuestion): void
    {
        $this->objectInQuestion = $objectInQuestion;
    }

    /**
     * @return ModelDTO|null
     */
    public function getModel(): ?ModelDTO
    {
        return $this->model;
    }

    /**
     * @param ModelDTO|null $model
     */
    public function setModel(?ModelDTO $model): void
    {
        $this->model = $model;
    }
}