<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * Test cases for the controller Debug.
 */
class SessionControllerTest extends WebTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testSession()
    {
        session_start();

        $client = static::createClient();
        $client->request('GET', '/session');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @runInSeparateProcess
     */
    public function testDestroy()
    {
        session_start();

        $client = static::createClient();
        $client->request('GET', '/session/destroy');
        
        $this->assertFalse(isset($_SESSION));
    }
}
