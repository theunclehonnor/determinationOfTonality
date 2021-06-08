<?php


namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class ReportDTO
{
    /**
     * @Serializer\Type("string")
     */
    private $createdAt;

    /**
     * @Serializer\Type("string")
     */
    private $file;

    /**
     * @var ?UserDTO
     * @Serializer\Type("App\Model\UserDTO")
     */
    private $userApi;

    /**
     * @var ObjectInQuestionDTO
     * @Serializer\Type("App\Model\ObjectInQuestionDTO")
     */
    private $objectInQuestion;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return ?UserDTO
     */
    public function getUserApi(): ?UserDTO
    {
        return $this->userApi;
    }

    /**
     * @param ?UserDTO $userApi
     */
    public function setUserApi(?UserDTO $userApi): void
    {
        $this->userApi = $userApi;
    }

    /**
     * @return ObjectInQuestionDTO
     */
    public function getObjectInQuestion(): ObjectInQuestionDTO
    {
        return $this->objectInQuestion;
    }

    /**
     * @param ObjectInQuestionDTO $objectInQuestion
     */
    public function setObjectInQuestion(ObjectInQuestionDTO $objectInQuestion): void
    {
        $this->objectInQuestion = $objectInQuestion;
    }
}
