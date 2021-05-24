<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RealtorControllerTest extends WebTestCase
{
    private static $client = null;

    public function setUp(): void
    {
        self::ensureKernelShutdown();
        if (null === self::$client) {
            self::$client = static::createClient();
        }
    }

    public function tearDown(): void
    {
        self::ensureKernelShutdown();
    }

    public function testHouses()
    {
        self::$client->request('GET', '/houses');

        $this->assertResponseIsSuccessful();
    }

    public function testHouseID()
    {
        self::$client->request('GET', '/houses/1');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateHouse()
    {
        self::$client->request('GET', '/create/house');

        $this->assertResponseIsSuccessful();
    }

    public function testEditHouse()
    {
        self::$client->request('GET', '/edit/house/1');

        $this->assertResponseIsSuccessful();
    }

    public function testAddRoom()
    {
        self::$client->request('GET', '/add/room/1');

        $this->assertResponseIsSuccessful();
    }

    public function testAddEnSuite()
    {
        self::$client->request('GET', '/add/ensuite/1/2');

        $this->assertResponseIsSuccessful();
    }
}
