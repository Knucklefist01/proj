<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;

class ScoresController extends AbstractController
{
    private $debug = [];

    public function collectHisto(EntityManagerInterface $entityManager)
    {
        $scores = $entityManager
            ->getRepository(Score::class)
            ->findAll();

        $histo = [];

        for ($x = 0; $x < 15; $x++) {
            $histo[$x] = [];
        }

        foreach ($scores as $score) {
            $value = $score->getValue();

            array_push($this->debug, $value);

            if ($value > 0 && $value <= 25) {
                array_push($histo[0], $value);
            } else if ($value > 25 && $value <= 50) {
                array_push($histo[1], $value);
            } else if ($value > 50 && $value <= 75) {
                array_push($histo[2], $value);
            } else if ($value > 75 && $value <= 100) {
                array_push($histo[3], $value);
            } else if ($value > 100 && $value <= 125) {
                array_push($histo[4], $value);
            } else if ($value > 125 && $value <= 150) {
                array_push($histo[5], $value);
            } else if ($value > 150 && $value <= 175) {
                array_push($histo[6], $value);
            } else if ($value > 175 && $value <= 200) {
                array_push($histo[7], $value);
            } else if ($value > 200 && $value <= 225) {
                array_push($histo[8], $value);
            } else if ($value > 225 && $value <= 250) {
                array_push($histo[9], $value);
            } else if ($value > 250 && $value <= 275) {
                array_push($histo[10], $value);
            } else if ($value > 275 && $value <= 300) {
                array_push($histo[11], $value);
            } else if ($value > 300 && $value <= 325) {
                array_push($histo[12], $value);
            } else if ($value > 325 && $value <= 350) {
                array_push($histo[13], $value);
            } else if ($value > 350 && $value <= 375) {
                array_push($histo[14], $value);
            }
        }

        return $histo;
    }

    /**
     * @Route("/highscores")
    */
    public function yatzyScores(EntityManagerInterface $entityManager)
    {
        $scores = $entityManager
            ->getRepository(Score::class)
            ->findAll();

        $histo = $this->collectHisto($entityManager);

        array_push($this->debug, $histo);

        return $this->render('scores.html.twig', [
            "data" => $scores,
            "histo" => $histo,
            "debug" => $this->debug
        ]);
    }

    /**
     * @Route("/highscores/{order}")
    */
    public function yatzyOrder(int $order, EntityManagerInterface $entityManager)
    {
        $debug = [];
        $histo = $this->collectHisto($entityManager);

        if ($order == 1) {
            $scores = $entityManager
                ->getRepository(Score::class)
                ->findBy(array(), array('value' => 'ASC'));
        } else if ($order == 2) {
            $scores = $entityManager
                ->getRepository(Score::class)
                ->findBy(array(), array('value' => 'DESC'));
        } else if ($order == 3) {
            $scores = $entityManager
                ->getRepository(Score::class)
                ->findBy(array(), array('id' => 'DESC'));
        } else {
            $scores = $entityManager
                ->getRepository(Score::class)
                ->findAll();
        }

        array_push($debug, $histo);

        return $this->render('scores.html.twig', [
            "data" => $scores,
            "histo" => $histo,
            "debug" => $this->debug
        ]);
    }
}
