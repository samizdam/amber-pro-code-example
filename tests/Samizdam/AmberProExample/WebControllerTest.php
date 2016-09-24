<?php

namespace Samizdam\AmberProExample;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class WebControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testActionIndex()
    {
        $controller = new WebController();
        $this->expectOutputString('Hello World!');
        $controller->actionIndex();
    }
}