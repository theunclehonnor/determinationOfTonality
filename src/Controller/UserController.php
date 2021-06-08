<?php


namespace App\Controller;


use App\Exception\ApiUnavailableException;
use App\Model\ReportDTO;
use App\Model\UserDTO;
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
    public function profile(): Response
    {
        try {
            $response = $this->apiClient->getCurrentUser($this->getUser(), $this->decodingJwt);
            $userDto = $this->serializer->deserialize($response, UserDTO::class, 'json');
        } catch (ApiUnavailableException | \Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $this->render('user/profile.html.twig', [
            'userDto' => $userDto,
        ]);
    }

    /**
     * @Route("/history", name="history")
     */
    public function history(): Response
    {
        try {
            $response = $this->apiClient->getHistory($this->getUser(), $this->decodingJwt);
            if ($response) {
                $reportsDto = $this->serializer->deserialize($response, 'array<App\Model\ReportDTO>', 'json');
            } else {
                $reportsDto = null;
            }
        } catch (ApiUnavailableException | \Exception $e) {
            throw new \Exception($e);
        }

        return $this->render('user/history.html.twig', [
            'reportsDto' => $reportsDto,
            'host' => $_ENV['API'] . ':82/',
//            'host' => 'file:///home/artem/diplom/determinationOfTonality_API/public/'
        ]);
    }
}