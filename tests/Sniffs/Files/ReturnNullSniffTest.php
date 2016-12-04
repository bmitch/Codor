<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group Files */
class ReturnNullSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.ReturnNull')->setFolder(__DIR__.'/Assets/ReturnNullSniff/');
    }

    /** @test */
    public function it_detects_functions_that_return_null()
    {
        $results = $this->runner->sniff('FunctionThatReturnsNull.inc');
        $this->assertEquals(2, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }
}