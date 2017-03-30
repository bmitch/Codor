<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group ControlStructures */
class NestedIfSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.ControlStructures.NestedIf')->setFolder(__DIR__.'/');
    }

    public function testSniff()
    {
        $results = $this->runner->sniff('NestedIfSniffTest.inc');
        $this->assertSame(6, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(6, $errorMessages);
        $this->assertAllEqual('Nested if statement found.', $errorMessages);
    }
}
