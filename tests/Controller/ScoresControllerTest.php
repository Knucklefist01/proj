<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class ScoresControllerTest extends WebTestCase
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


    public function testHighscores()
    {
        self::$client->request('GET', '/highscores');

        $this->assertResponseIsSuccessful();
    }

    public function testOrderValueAsc()
    {
        self::$client->request('GET', '/highscores/1');

        $this->assertResponseIsSuccessful();
    }

    public function testOrderValueDesc()
    {
        self::$client->request('GET', '/highscores/2');

        $this->assertResponseIsSuccessful();
    }

    public function testOrderIdDesc()
    {
        self::$client->request('GET', '/highscores/3');

        $this->assertResponseIsSuccessful();
    }

    public function testOrderElse()
    {
        self::$client->request('GET', '/highscores/45');

        $this->assertResponseIsSuccessful();
    }
}
