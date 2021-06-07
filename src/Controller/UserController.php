<?php


namespace App\Controller;


use App\Exception\ApiUnavailableException;
use App\Model\UserDto;
use App\Service\ApiClient;
use App\Service\DecodingJwt;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $apiClient;
    private $decodingJwt;
    private $serializer;

    public function __construct(
        ApiClient $apiClient,
        DecodingJwt $decodingJwt,
        SerializerInterface $serializer
    ) {
        $this->apiClient = $apiClient;
        $this->decodingJwt = $decodingJwt;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        try {
            $response = $this->apiClient->getCurrentUser($this->getUser(), $this->decodingJwt);
            $userDto = $this->serializer->deserialize($response, UserDto::class, 'json');
        } catch (ApiUnavailableException $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->render('user/profile.html.twig', [
            'userDto' => $userDto,
        ]);
    }
}