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
}