<?php


namespace App\Service;

use App\Exception\ApiUnavailableException;
use App\Exception\ClientException;
use App\Model\UserDTO;
use App\Security\User;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ApiClient
{
    private $startUri;
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->startUri = $_ENV['API'];
        $this->serializer = $serializer;
    }

    public function refreshToken(string $refreshToken): UserDTO
    {
        $userDto = new UserDTO();
        $userDto->setRefreshToken($refreshToken);
        $resp = $this->serializer->serialize($userDto, 'json');

        // Запрос в сервис биллинг
        $query = curl_init($this->startUri . '/api/v1/token/refresh');
        curl_setopt($query, CURLOPT_POST, 1);
        curl_setopt($query, CURLOPT_POSTFIELDS, $resp);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен.
            Попробуйте авторизоваться позднее');
        }
        curl_close($query);

        /** @var UserDTO $userDto */
        $userDto = $this->serializer->deserialize($response, UserDTO::class, 'json');

        return $userDto;
    }

    /**
     * @throws ApiUnavailableException
     */
    public function auth(string $request): UserDTO
    {
        // Запрос в сервис биллинг
        $query = curl_init($this->startUri . '/api/v1/auth');
        curl_setopt($query, CURLOPT_POST, 1);
        curl_setopt($query, CURLOPT_POSTFIELDS, $request);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($request)
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Возникли технические неполадки. Попробуйте позднее');
        }
        curl_close($query);

        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code'])) {
            if ($result['code'] === 401) {
                throw new ApiUnavailableException('Проверьте правильность введёного логина и пароля');
            }
        }
        /** @var UserDTO $userDto */
        $userDto = $this->serializer->deserialize($response, UserDTO::class, 'json');

        return $userDto;
    }

    /**
     * @throws ApiUnavailableException
     */
    public function getCurrentUser(User $user, DecodingJwt $decodingJwt)
    {
        // Декодируем токен
//        $decodingJwt->decoding($user->getApiToken());

        // Запрос в сервис биллинг, получение данных
        $query = curl_init($this->startUri . '/api/v1/users/profile');
        curl_setopt($query, CURLOPT_HTTPGET, 1);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $user->getApiToken()
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен. 
            Попробуйте авторизоваться позднее');
        }
        curl_close($query);

        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code'])) {
            throw new ApiUnavailableException($result['message']);
        }

        return $response;
    }

    /**
     * @throws ApiUnavailableException
     * @throws ClientException
     */
    public function register(UserDTO $dataUser): UserDTO
    {
        $dataSerialize = $this->serializer->serialize($dataUser, 'json');
        // Запрос в сервис биллинг
        $query = curl_init($this->startUri . '/api/v1/register');
        curl_setopt($query, CURLOPT_POST, 1);
        curl_setopt($query, CURLOPT_POSTFIELDS, $dataSerialize);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataSerialize)
        ]);
        $response = curl_exec($query);

        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен. 
            Попробуйте зарегистрироваться позднее');
        }
        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code'])) {
            if ($result['code'] == 403) {
                throw new ClientException($result['message']);
            }

            throw new ApiUnavailableException('Сервис временно недоступен. 
        Попробуйте зарегистрироваться позднее');
        }
        curl_close($query);

        /** @var UserDTO $userDto */
        $userDto = $this->serializer->deserialize($response, UserDTO::class, 'json');

        return $userDto;
    }

    /**
     * @throws ApiUnavailableException
     */
    public function getHistory(User $user, DecodingJwt $decodingJwt)
    {
        // Декодируем токен
//        $decodingJwt->decoding($user->getApiToken());

        // Запрос в сервис биллинг, получение данных
        $query = curl_init($this->startUri . '/api/v1/users/history');
        curl_setopt($query, CURLOPT_HTTPGET, 1);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $user->getApiToken()
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен. 
            Попробуйте позднее');
        }
        curl_close($query);

        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code'])) {
            if ($result['code'] === Response::HTTP_NOT_FOUND) {
                $response = null;
            } else {
                throw new ApiUnavailableException('Сервис временно недоступен. 
        Попробуйте позднее');
            }
        }

        return $response;
    }

    public function analyze(User $user, array $data, string $method)
    {
        $response = $this->serializer->serialize($data, 'json');
        $query = curl_init($this->startUri . '/api/v1/'.$method);
        curl_setopt($query, CURLOPT_POST, 1);
        curl_setopt($query, CURLOPT_POSTFIELDS, $response);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $user->getApiToken(),
            'Content-Length: ' . strlen($response)
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен. 
            Попробуйте позднее');
        }
        curl_close($query);

        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code']) && $result['code'] !== Response::HTTP_CREATED) {
                throw new ApiUnavailableException($result['message'], $result['code']);
        }

        return $result;
    }

    public function createReport(User $user, int $id_report)
    {
        $query = curl_init($this->startUri . '/api/v1/report/create?id_report='.$id_report);
        curl_setopt($query, CURLOPT_POST, 1);
        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($query, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $user->getApiToken(),
        ]);
        $response = curl_exec($query);
        // Ошибка с биллинга
        if ($response === false) {
            throw new ApiUnavailableException('Сервис временно недоступен. 
            Попробуйте позднее');
        }
        curl_close($query);

        // Ответа от сервиса
        $result = json_decode($response, true);
        if (isset($result['code']) && $result['code'] !== Response::HTTP_CREATED) {
            throw new ApiUnavailableException($result['message'], $result['code']);
        }

        return $result;
    }

//    /**
//     * @throws ApiUnavailableException
//     */
//    public function getDistinctModel(User $user)
//    {
//        // Запрос в сервис биллинг, получение данных
//        $query = curl_init($this->startUri . '/api/v1/model/distinct');
//        curl_setopt($query, CURLOPT_HTTPGET, 1);
//        curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($query, CURLOPT_HTTPHEADER, [
//            'Content-Type: application/json',
//            'Authorization: Bearer ' . $user->getApiToken()
//        ]);
//        $response = curl_exec($query);
//        // Ошибка с биллинга
//        if ($response === false) {
//            throw new ApiUnavailableException('Сервис временно недоступен.
//            Попробуйте позднее');
//        }
//        curl_close($query);
//
//        // Ответа от сервиса
//        $result = json_decode($response, true);
//        if (isset($result['code'])) {
//            throw new ApiUnavailableException($result['message'], $result['code']);
//        }
//
//        return $result;
//    }
}
