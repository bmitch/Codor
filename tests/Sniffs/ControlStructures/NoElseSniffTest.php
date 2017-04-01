<?php declare(strict_types = 1);

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
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(5, $errorMessages);
        $this->assertAllEqual('Do not use "else" or "elseif"', $errorMessages);
    }
}
