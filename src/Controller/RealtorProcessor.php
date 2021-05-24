<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\House;
use App\Entity\Room;
use App\Entity\Bedroom;
use App\Entity\Bathroom;

/**
 * Controller for a sample route an controller class.
 */
class RealtorProcessor extends AbstractController
{
    /**
     * @Route("/createHouse")
    */
    public function createHouse()
    {
        if (isset($_POST["createHouse"])) {
            $entityManager = $this->getDoctrine()->getManager();

            $newHouse = new House();
            $newHouse->setAddress($_POST["houseAddress"]);
            $newHouse->setDescription($_POST["houseDesc"]);

            $entityManager->persist($newHouse);
            $entityManager->flush();
        }

        return $this->redirect("houses");
    }



    /**
     * @Route("/editHouse")
    */
    public function house()
    {
        $houseId = $_POST["houseId"];

        $entityManager = $this->getDoctrine()->getManager();

        if (isset($_POST["editHouse"])) {
            $room = $entityManager->getRepository(House::class)->find($houseId);

            $room->setAddress($_POST["editAddress"]);
            $room->setDescription($_POST["editDesc"]);

            $entityManager->persist($room);
            $entityManager->flush();
        } else if (isset($_POST["removeHouse"])) {
            $room = $entityManager->getRepository(House::class)->find($houseId);

            $entityManager->remove($room);
            $entityManager->flush();

            return $this->redirect("houses");
        } else if (isset($_POST["addRoom"])) {
            if ($_POST["addType"] == "Bedroom") {
                $room = new Bedroom();
                $room->setBed($_POST["addBed"]);
            } else if ($_POST["addType"] == "Bathroom") {
                $room = new Bathroom();
                $room->setSinks($_POST["addSinks"]);
                $room->setToilets($_POST["addToilets"]);
            } else {
                $room = new Room();
            }

            $room->setName($_POST["addName"]);
            $room->setWindows($_POST["addWindows"]);
            $room->setFloor($_POST["addFloor"]);
            $room->setHouseId($houseId);

            $entityManager->persist($room);
            $entityManager->flush();
        } else if (isset($_POST["addEnSuite"])) {
            $room = new Bathroom();

            $room->setName($_POST["addName"]);
            $room->setWindows($_POST["addWindows"]);
            $room->setFloor($_POST["addFloor"]);
            $room->setSinks($_POST["addSinks"]);
            $room->setToilets($_POST["addToilets"]);

            $entityManager->persist($room);
            $entityManager->flush();

            $enSuiteId = $room->getId();

            $bedroom = $entityManager->getRepository(Bedroom::class)->find($_POST["editId"]);
            $bedroom->setEnSuite($enSuiteId);

            $entityManager->persist($bedroom);
            $entityManager->flush();
        }

        return $this->redirect("edit/house/" . $houseId);
    }





    /**
     * @Route("/editBedroom")
    */
    public function bedroom()
    {
        $houseId = $_POST["houseId"];
        $editId = $_POST["editId"];

        $entityManager = $this->getDoctrine()->getManager();

        if (isset($_POST["editBedroom"])) {
            $room = $entityManager->getRepository(Bedroom::class)->find($editId);

            $room->setName($_POST["editName"]);
            $room->setFloor($_POST["editFloor"]);
            $room->setWindows($_POST["editWindows"]);

            $room->setBed($_POST["editBed"]);

            $entityManager->persist($room);
            $entityManager->flush();
        } else if (isset($_POST["removeBedroom"])) {
            $room = $entityManager->getRepository(Bedroom::class)->find($editId);

            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirect("edit/house/" . $houseId);
        /*
        return new Response(
            var_dump($room)
        );
        */
    }


    /**
     * @Route("/editBathroom")
    */
    public function bathroom()
    {
        $houseId = $_POST["houseId"];
        $editId = $_POST["editId"];

        $entityManager = $this->getDoctrine()->getManager();

        if (isset($_POST["editBathroom"])) {
            $room = $entityManager->getRepository(Bathroom::class)->find($editId);

            $room->setName($_POST["editName"]);
            $room->setWindows($_POST["editWindows"]);
            $room->setFloor($_POST["editFloor"]);

            $room->setSinks($_POST["editSinks"]);
            $room->setToilets($_POST["editToilets"]);

            $entityManager->persist($room);
            $entityManager->flush();
        } else if (isset($_POST["removeBathroom"])) {
            $room = $entityManager->getRepository(Bathroom::class)->find($editId);

            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirect("edit/house/" . $houseId);
        /*
        return new Response(
            var_dump($room)
        );
        */
    }



    /**
     * @Route("/editRoom")
    */
    public function room()
    {
        $houseId = $_POST["houseId"];
        $editId = $_POST["editId"];

        $entityManager = $this->getDoctrine()->getManager();

        if (isset($_POST["editRoom"])) {
            $room = $entityManager->getRepository(Room::class)->find($editId);

            $room->setName($_POST["editName"]);
            $room->setWindows($_POST["editWindows"]);
            $room->setFloor($_POST["editFloor"]);

            $entityManager->persist($room);
            $entityManager->flush();
        } else if (isset($_POST["removeRoom"])) {
            $room = $entityManager->getRepository(Room::class)->find($editId);

            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirect("edit/house/" . $houseId);
        /*
        return new Response(
            var_dump($room)
        );
        */
    }
}
