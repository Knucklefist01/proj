<?php

declare(strict_types=1);

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\House;
use App\Entity\Room;
use App\Entity\Bedroom;
use App\Entity\Bathroom;

class RealtorProcessorTest extends WebTestCase
{

    public function testCreateHouse()
    {
        // create entity manager mock
        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(array('persist', 'flush'))
            ->disableOriginalConstructor()
            ->getMock();

        // now you can get some assertions if you want, eg.:
        $entityManagerMock->expects($this->once())
            ->method('flush');

        // next you need inject your mocked em into client's service container
        $client = static::createClient();
        $client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManagerMock);

        // then you just do testing as usual
        $_POST["createHouse"] = true; 
        $_POST["houseAddress"] = "Testgatan 1"; 
        $_POST["houseDesc"] = "Detta huset är ett test"; 
        $crawler = $client->request('POST', '/createHouse');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testEditHouse()
    {
        
    }
}
}
