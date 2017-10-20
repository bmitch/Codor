<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\TypeHints;

use Codor\Tests\BaseTestCase;

/** @group TypeHints */
class MixedReturnTypeSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->runner->setSniff('Codor.TypeHints.MixedReturnType')->setFolder(__DIR__.'/Assets/MixedReturnTypeSniff/');
    }

    /** @test */
    public function it_produces_an_error_when_a_function_has_a_mixed_return_type()
    {
        $results = $this->runner->sniff('FunctionsWithMixedReturns.inc');

        $this->assertEquals(8, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(8, $errorMessages);
        $this->assertAllEqual('Function return type contains mixed', $errorMessages);
    }

    /** @test */
    public function it_does_not_detect_any_errors_when_all_methods_have_non_mixed_returns()
    {
        $results = $this->runner->sniff('FunctionsWithNonMixedReturns.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    /** @test */
    public function it_works_with_interfaces()
    {
        $results = $this->runner->sniff('Interface.inc');
        $this->assertEquals(2, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
    }
}
