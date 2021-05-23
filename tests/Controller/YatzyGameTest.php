<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;



class YatzyGameTest extends WebTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testYatzy()
    {
        $client = static::createClient();
        $client->request('GET', '/yatzy');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'MVC Projekt | Yatzy');
        $this->assertTrue(isset($_SESSION["yatzyGame"]));
    }
}
