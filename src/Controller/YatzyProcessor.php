<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Dice\Yatzy;
use App\Entity\Score;

/**
 * Controller for a sample route an controller class.
 */
class YatzyProcessor extends AbstractController
{
    /**
     * @Route("/yatzyProcessor")
    */
    public function __invoke()
    {
        if (isset($_POST["throwSubmit"])) {
            $keep = [];

            if (isset($_POST["cube0"])) {
                array_push($keep, 0);
            }
            if (isset($_POST["cube1"])) {
                array_push($keep, 1);
            }
            if (isset($_POST["cube2"])) {
                array_push($keep, 2);
            }
            if (isset($_POST["cube3"])) {
                array_push($keep, 3);
            }
            if (isset($_POST["cube4"])) {
                array_push($keep, 4);
            }
            $_SESSION["yatzyGame"]->throwDice($keep);
        } else if (isset($_POST["pointsSubmit"])) {
            $_SESSION["yatzyGame"]->pickPoints($_POST["category"], $_POST["points"]);
        } else if (isset($_POST["resetSubmit"])) {
            $data = $_SESSION["yatzyGame"]->getData();
            unset($_SESSION["yatzyGame"]);

        } else if (isset($_POST["saveSubmit"])) {
            $data = $_SESSION["yatzyGame"]->getData();

            if ($data["scoreTotal"] > 0) {
                // spara score i databasen
                $entityManager = $this->getDoctrine()->getManager();

                $storeScore = new Score();
                $storeScore->setValue($data["scoreTotal"]);

                $entityManager->persist($storeScore);
                $entityManager->flush();
            }

            unset($_SESSION["yatzyGame"]);
        }

        return $this->redirect("yatzy");
    }
}
