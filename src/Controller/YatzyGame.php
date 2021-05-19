<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Dice\Yatzy;

/**
 * Controller for a sample route an controller class.
 */
class YatzyGame extends AbstractController
{
    /**
     * @Route("/yatzy")
    */
    public function __invoke()
    {
        if (!isset($_SESSION["yatzyGame"])) {
            $_SESSION["yatzyGame"] = new Yatzy();
        }
        $data = $_SESSION["yatzyGame"]->getData();

        return $this->render('yatzy.html.twig', $data);
    }
}
