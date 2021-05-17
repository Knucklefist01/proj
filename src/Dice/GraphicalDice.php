<?php

declare(strict_types=1);

namespace App\Dice;

/*
use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};
*/

/**
 * Class GraphicalDice.
 */
class GraphicalDice extends Dice
{
    const FACES = 6;

    public function getRollFile(): string
    {
        $fileName = "dice" . $this->getLastRoll() . ".png";
        return $fileName;
    }
}
