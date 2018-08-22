<?php

namespace App\Service;

/**
 * Class SocialNetworkApi
 * @package AppBundle\Service
 */
class SocialNetworkApi
{
    protected $client;

    /**
     * SocialNetworkApi constructor.
     * @param RestClient $client
     */
    public function __construct(RestClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $page
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserList(int $page)
    {
        return $this->client->callApi(
            '/user/lists/',
            'GET',
            ['query' => ['page' => $page]]
        );
    }

    /**
     * @param int $userId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserConnectionsList(int $userId)
    {
        return $this->client->callApi(
            '/user/connections/',
            'GET',
            ['query' => ['userId' => $userId]]
        );
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBandList()
    {
        return $this->client->callApi(
            '/band/list/',
            'GET'
        );
    }

    /**
     * @param int $bandId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBandUsers(int $bandId)
    {
        return $this->client->callApi(
            '/band/users/',
            'GET',
            ['query' => ['bandId' => $bandId]]
        );
    }

    /**
     * @param int $bandId
     * @param int $userAId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPotentialConnectionUsers(int $bandId, int $userAId)
    {
        return $this->client->callApi(
            '/user-band/potential-connection-user-list/',
            'GET',
            ['query' => ['bandId' => $bandId, 'userAId' => $userAId]]
        );
    }

    /**
     * @param int $bandId
     * @param int $userAId
     * @param int $userBId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function connectUsers(int $bandId, int $userAId, int $userBId)
    {
        return $this->client->callApi(
            '/connection/users/',
            'POST',
            ['form_params' => ['bandId' => $bandId, 'userAId' => $userAId, 'userBId' => $userBId]]
        );
    }
}