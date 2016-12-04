<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group ControlStructures */
class NoElseSniffTest extends BaseTestCase
{

	public function setup()
	{
		parent::setup();

		$this->runner->setSniff('Codor.ControlStructures.NoElse')->setFolder(__DIR__.'/');
	}

    public function testSniff()
    {
 		$results = $this->runner->sniff('NoElseSniffTest.inc');
        $this->assertSame(5, $results->getErrorCount());
    }
}