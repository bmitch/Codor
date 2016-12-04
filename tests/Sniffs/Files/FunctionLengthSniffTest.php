<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group Files */
class FunctionLengthSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
	public function setup()
	{
		parent::setup();

		$this->runner->setSniff('Codor.Files.FunctionLength')->setFolder(__DIR__.'/Assets/FunctionLengthSniff/');
	}

	/** @test */
    public function it_detects_functions_that_are_over_the_max_allowed()
    {
 		$results = $this->runner->sniff('FunctionLengthSniff.inc');
        $this->assertSame(2, $results->getErrorCount());
    }
}