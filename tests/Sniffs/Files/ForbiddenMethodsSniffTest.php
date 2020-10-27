<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Files;

use Codor\Tests\BaseTestCase;

/** @group Files */
class ForbiddenMethodsSniffTest extends BaseTestCase
{
    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.ForbiddenMethods')->setFolder(__DIR__.'/Assets/ForbiddenMethodsSniff/');
    }

    /** @test */
    public function it_produces_errors_for_each_forbidden_method_call_found()
    {
        $results = $this->runner->sniff('CallingForbiddenMethods.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertSame('Call to method raw is forbidden.', $errorMessages[0]);
        $this->assertSame('Call to method statement is forbidden.', $errorMessages[1]);
    }

    /** @test */
    public function it_produces_errors_for_each_forbidden_method_static_call_found()
    {
        $results = $this->runner->sniff('CallingForbiddenMethodsStatic.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertSame('Call to method raw is forbidden.', $errorMessages[0]);
        $this->assertSame('Call to method statement is forbidden.', $errorMessages[1]);
    }
}
