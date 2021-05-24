<?php

declare(strict_types=1);

namespace App\Controller;

use PHPUnit\Framework\TestCase;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Dice\Yatzy;

class YatzyProcessorTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testThrowSubmit()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $_POST["throwSubmit"] = true;

        $processor->__invoke();

        $data = $_SESSION["yatzyGame"]->getData();
        $this->assertEquals($data["throws"], 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testThrowKeepSome()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $data = $_SESSION["yatzyGame"]->setData("hand", [6, 6, 6, 1, 1]);

        $_POST["throwSubmit"] = true;
        $_POST["cube0"] = true;
        $_POST["cube1"] = true;
        $_POST["cube2"] = true;

        $processor->__invoke();

        $data = $_SESSION["yatzyGame"]->getData();
        $this->assertEquals($data["throws"], 1);
        $this->assertEquals($data["hand"][0], 6);
        $this->assertEquals($data["hand"][1], 6);
        $this->assertEquals($data["hand"][2], 6);
    }

    /**
     * @runInSeparateProcess
     */
    public function testThrowKeepSomeElse()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $data = $_SESSION["yatzyGame"]->setData("hand", [6, 6, 6, 1, 1]);

        $_POST["throwSubmit"] = true;
        $_POST["cube3"] = true;
        $_POST["cube4"] = true;

        $processor->__invoke();

        $data = $_SESSION["yatzyGame"]->getData();
        $this->assertEquals($data["throws"], 1);
        $this->assertEquals($data["hand"][3], 1);
        $this->assertEquals($data["hand"][4], 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testPointsSubmit()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $_POST["pointsSubmit"] = true;
        $_POST["category"] = "Ones";
        $_POST["points"] = 4;

        $processor->__invoke();

        $data = $_SESSION["yatzyGame"]->getData();
        $this->assertEquals($data["scoreLocked"]["Ones"], 4);
    }

    /**
     * @runInSeparateProcess
     */
    public function testResetSubmit()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $_POST["resetSubmit"] = true;

        $processor->__invoke();

        $this->assertFalse(isset($_SESSION["yatzyGame"]));
    }

    /**
     * @runInSeparateProcess
     */
    public function testSaveSubmit()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $_POST["saveSubmit"] = true;

        $processor->__invoke();

        $this->assertFalse(isset($_SESSION["yatzyGame"]));
    }

    /**
     * @runInSeparateProcess
     */
    /*
    public function testSaveWithScore()
    {
        session_start();
        $_SESSION["yatzyGame"] = new Yatzy();
        $processor = new YatzyProcessor();

        $_POST["saveSubmit"] = true;
        $_SESSION["yatzyGame"]->setData("scoreTotal", 164);

        $processor->__invoke();

        $this->assertFalse(isset($_SESSION["yatzyGame"]));
    }
    */
}
