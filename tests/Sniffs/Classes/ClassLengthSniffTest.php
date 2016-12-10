<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class ClassLengthSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.ClassLength')->setFolder(__DIR__.'/');
    }

    public function testSniff()
    {
        $results = $this->runner->sniff('ClassLengthSniff.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class is 202 lines. Must be 200 lines or fewer.', $errorMessages);

    }
}