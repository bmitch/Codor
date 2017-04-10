<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Files;

use Codor\Tests\BaseTestCase;

/** @group Files */
class FunctionParameterSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.FunctionParameter')->setFolder(__DIR__.'/Assets/FunctionParameterSniff/');
    }

    /** @test */
    public function it_produces_an_error_when_a_function_has_4_or_more_parameters()
    {
        $results = $this->runner->sniff('FunctionsWithFourOrMoreParameters.inc');
        $this->assertEquals(4, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(4, $errorMessages);
        $this->assertAllEqual('Function has more than 3 parameters. Please reduce.', $errorMessages);
    }

    /** @test */
    public function it_produces_a_warning_when_a_function_has_3_parameters()
    {
        $results = $this->runner->sniff('FunctionWithThreeParameters.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(2, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(2, $warningMessages);
        $this->assertAllEqual('Function has 3 parameters.', $warningMessages);
    }

    /** @test */
    public function it_produces_no_warnings_or_errors_with_functions_with_2_or_fewer_parameters()
    {
        $results = $this->runner->sniff('FunctionWithTwoOrFewerParameters.inc');
        $this->assertEquals(0, $results->getWarningCount());
        $this->assertEquals(0, $results->getErrorCount());
    }

    /** @test */
    public function it_produces_errors_on_interfaces()
    {
        $results = $this->runner->sniff('Interfaces.inc');
        $this->assertEquals(2, $results->getErrorCount());
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Function has more than 3 parameters. Please reduce.', $errorMessages);
    }

    /** @test */
    public function it_produces_warnings_on_interfaces()
    {
        $results = $this->runner->sniff('Interfaces.inc');
        $this->assertEquals(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
        $this->assertAllEqual('Function has 3 parameters.', $warningMessages);
    }
}
