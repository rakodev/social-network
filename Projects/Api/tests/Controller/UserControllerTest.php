<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 * @package App\Tests\Controller
 */
class UserControllerTest extends WebTestCase
{
    public function testListUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/user/lists/');

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode());
        $this->assertArrayHasKey('users',json_decode($response->getContent(), true));
    }

    public function testListUserConnection()
    {
        $client = static::createClient();

        $client->request('GET', '/user/connections/');

        $response = $client->getResponse();

        $this->assertEquals( 200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('connections',json_decode($response->getContent(), true));
    }
}