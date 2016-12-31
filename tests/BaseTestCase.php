<?php

namespace Codor\Tests;

use Codor\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * The CodeSnifferRunner;
     * @var CodeSnifferRunner
     */
    protected $runner;

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner = new CodeSnifferRunner();
    }

    /**
     * Asserts all the elements within $array are
     * equal to $value.
     * @param  mixed $value Value to compapre.
     * @param  array $array Array to compare.
     * @return void
     */
    public function assertAllEqual($value, array $array)
    {
        foreach ($array as $element) {
            $this->assertEquals($value, $element);
        }
    }
}
