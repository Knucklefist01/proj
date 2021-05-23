<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;



class RealtorControllerTest extends WebTestCase
{

    public function testHouses()
    {
        $client = static::createClient();
        $client->request('GET', '/houses');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'MVC Projekt | Houses');
    }

    public function testHouseID()
    {
        $client = static::createClient();
        $client->request('GET', '/houses/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'MVC Projekt | Houses');
    }
}
