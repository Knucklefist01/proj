<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Room\HouseClass;
use App\Room\RoomClass;
use App\Room\BathroomClass;
use App\Room\BedroomClass;
use App\Entity\House;
use App\Entity\Room;
use App\Entity\Bedroom;
use App\Entity\Bathroom;

/**
 * Controller for a sample route an controller class.
 */
class RealtorController extends AbstractController
{
    private $debug = [];
    private $houseArray = [];

    public function arrangeObject(EntityManagerInterface $entityManager)
    {
        $houses = $this->getTable($entityManager, House::class);
        $rooms = $this->getTable($entityManager, Room::class);
        $bedrooms = $this->getTable($entityManager, Bedroom::class);
        $bathrooms = $this->getTable($entityManager, Bathroom::class) ;

        $this->houseArray = [];

        foreach ($houses as $house) {
            $toAdd =  new HouseClass(
                $house->getId(),
                $house->getAddress(),
                $house->getDescription()
            );
            $this->houseArray[$house->getId()] = $toAdd;
        }

        foreach ($rooms as $index => $room) {
            if ($room->getHouseId() and isset($this->houseArray[$room->getHouseId()]) ) {
                $this->houseArray[$room->getHouseId()]->addRoom(
                    new RoomClass(
                        $rooms[$index]->getId(),
                        $rooms[$index]->getHouseId(),
                        $rooms[$index]->getName(),
                        $rooms[$index]->getWindows(),
                        $rooms[$index]->getFloor()
                    )
                );
            }
        }

        foreach ($bedrooms as $index => $bed) {
            if ($bed->getHouseId() and isset($this->houseArray[$room->getHouseId()])) {
                $enSuite = null;

                if ($bedrooms[$index]->getEnSuite()) {
                    foreach ($bathrooms as $innerIndex => $bath) {
                        if ($bedrooms[$index]->getEnSuite() == $bath->getId()) {
                            $enSuite = new BathroomClass(
                                $bathrooms[$innerIndex]->getId(),
                                $bathrooms[$innerIndex]->getHouseId(),
                                $bathrooms[$innerIndex]->getName(),
                                $bathrooms[$innerIndex]->getWindows(),
                                $bathrooms[$innerIndex]->getFloor(),
                                $bathrooms[$innerIndex]->getSinks(),
                                $bathrooms[$innerIndex]->getToilets()
                            );
                        }
                    }
                }

                $this->houseArray[$bed->getHouseId()]->addRoom(
                    new BedroomClass(
                        $bedrooms[$index]->getId(),
                        $bedrooms[$index]->getHouseId(),
                        $bedrooms[$index]->getName(),
                        $bedrooms[$index]->getWindows(),
                        $bedrooms[$index]->getFloor(),
                        $bedrooms[$index]->getBed(),
                        $enSuite
                    )
                );
            }
        }

        foreach ($bathrooms as $index => $bath) {
            if ($bath->getHouseId() and isset($this->houseArray[$room->getHouseId()])) {
                $this->houseArray[$bath->getHouseId()]->addRoom(
                    new BathroomClass(
                        $bathrooms[$index]->getId(),
                        $bathrooms[$index]->getHouseId(),
                        $bathrooms[$index]->getName(),
                        $bathrooms[$index]->getWindows(),
                        $bathrooms[$index]->getFloor(),
                        $bathrooms[$index]->getSinks(),
                        $bathrooms[$index]->getToilets()
                    )
                );
            }
        }
    }

    public function getTable($entityManager, $class)
    {
        $res = $entityManager
            ->getRepository($class)
            ->findAll();
        array_push($this->debug, $res);
        return $res;
    }

    /**
     * @Route("/houses")
    */
    public function realtor(EntityManagerInterface $entityManager)
    {
        $this->arrangeObject($entityManager);

        return $this->render('realtor.html.twig', [
            "debug" => $this->debug,
            "objects" => $this->houseArray,
        ]);
    }

    /**
     * @Route("/houses/{houseId}")
    */
    public function property(int $houseId, EntityManagerInterface $entityManager): Response
    {
        $this->arrangeObject($entityManager);

        return $this->render('property.html.twig', [
            "debug" => $this->debug,
            "houseId" => $houseId,
            "houseObject" => $this->houseArray[$houseId],
        ]);
    }

    /**
     * @Route("/create/house")
    */
    public function createHouse(): Response
    {
        return $this->render('createHouse.html.twig');
    }

    /**
     * @Route("/edit/house/{houseId}")
    */
    public function editHouse(int $houseId, EntityManagerInterface $entityManager): Response
    {
        $this->arrangeObject($entityManager);

        return $this->render('editHouse.html.twig', [
            "houseId" => $houseId,
            "houseObject" => $this->houseArray[$houseId],
        ]);
    }

    /**
     * @Route("/add/room/{houseId}")
    */
    public function addRoom(int $houseId, EntityManagerInterface $entityManager): Response
    {
        $this->arrangeObject($entityManager);

        return $this->render('addRoom.html.twig', [
            "houseId" => $houseId,
            "houseObject" => $this->houseArray[$houseId],
        ]);
    }

    /**
     * @Route("/add/ensuite/{houseId}/{bedroomId}")
    */
    public function addEnSuite(int $houseId, int $bedroomId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $room = $entityManager->getRepository(Bedroom::class)->find($bedroomId);


        return $this->render('addEnSuite.html.twig', [
            "houseId" => $houseId,
            "roomObject" => $room,
            "bedroomId" => $bedroomId,
        ]);
    }
}
