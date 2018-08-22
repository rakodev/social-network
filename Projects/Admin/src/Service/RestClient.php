<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class RestClient
 * @package AppBundle\Service
 */
class RestClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * RestClient constructor.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApi(string $path, string $method, array $options = [])
    {
        $client = new Client();
        try {
            $response = $client->request($method,$this->baseUrl.$path,$options);
        } catch (\Exception $e) {
            if(!($e instanceof ClientException)) {
                throw new \Exception('Api Error: '. $e->getMessage());
            }
            $response = $e->getResponse();
        }

        $contents = $response->getBody()->getContents();
        $responseContent = json_decode($contents, true);

        return $responseContent;
    }
}