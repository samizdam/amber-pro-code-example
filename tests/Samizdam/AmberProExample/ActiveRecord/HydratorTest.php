<?php

namespace Samizdam\AmberProExample\ActiveRecord;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class HydratorTest extends \PHPUnit_Framework_TestCase
{

    public function testHydrate()
    {
        $hydrator = new Hydrator();
        $hydrable = new class
        {
            private $_field;
            public $foo = 'foo';
        };
        $hydrable->dynamic = 'bar';
        $data = $hydrator->hydrate($hydrable);
        $expected = [
            'foo' => 'foo',
            'dynamic' => 'bar',
        ];
        $this->assertEquals($expected, $data);
    }
}