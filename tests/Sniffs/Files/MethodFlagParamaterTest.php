<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group Files */
class MethodFlagParamaterTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.MethodFlagParameter')->setFolder(__DIR__.'/Assets/MethodFlagParamater/');
    }

    /** @test */
    public function it_detects_functions_that_are_over_the_max_allowed()
    {
        $results = $this->runner->sniff('MethodFlagParamater.inc');
        $this->assertSame(12, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(10, $errorMessages);
        $this->assertAllEqual('Function/method contains a flag parameter.', $errorMessages);
    }
}
