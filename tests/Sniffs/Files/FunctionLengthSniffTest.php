<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Files;

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
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Function is 21 lines. Must be 20 lines or fewer.', $errorMessages);
    }
}
