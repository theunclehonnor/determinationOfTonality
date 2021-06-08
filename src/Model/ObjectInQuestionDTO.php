<?php


namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class ObjectInQuestionDTO
{
    /**
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Type("string")
     */
    private $image;

    /**
     * @Serializer\Type("string")
     */
    private $link;

    /**
     * @Serializer\Type("string")
     */
    private $fileReviews;

    /**
     * @var ModelDTO
     * @Serializer\Type("App\Model\ModelDTO")
     */
    private $model;

    /**
     * @var ResourceDTO
     * @Serializer\Type("App\Model\ResourceDTO")
     */
    private $resource;

    public function getLink()
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getFileReviews()
    {
        return $this->fileReviews;
    }

    public function setFileReviews(?string $fileReviews): void
    {
        $this->fileReviews = $fileReviews;
    }

    /**
     * @return ModelDTO
     */
    public function getModel(): ModelDTO
    {
        return $this->model;
    }

    /**
     * @param ?ModelDTO $model
     */
    public function setModel(?ModelDTO $model): void
    {
        $this->model = $model;
    }

    /**
     * @return ResourceDTO
     */
    public function getResource(): ResourceDTO
    {
        return $this->resource;
    }

    /**
     * @param ?ResourceDTO $resource
     */
    public function setResource(?ResourceDTO $resource): void
    {
        $this->resource = $resource;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}
