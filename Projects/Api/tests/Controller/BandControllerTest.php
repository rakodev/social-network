<?php

namespace App\Tests\Controller;

use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BandControllerTest
 * @package App\Tests\Controller
 */
class BandControllerTest extends WebTestCase
{

    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', '/band/list/');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('bands',json_decode($response->getContent(), true));
    }


    public function testUsers()
    {
        $band = new Band();
        $repository = $this->createMock(BandRepository::class);
        $repository->expects($this->any())
            ->method('find')
            ->willReturn($band);
        $client = static::createClient();

        $client->request('GET', '/band/users/', ['bandId' => $band->getId()]);

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertArrayHasKey('users',json_decode($response->getContent(), true));
    }
}