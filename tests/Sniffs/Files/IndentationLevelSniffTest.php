<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group Files */
class IndentationLevelSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.IndentationLevel')->setFolder(__DIR__.'/Assets/IndentationLevelSniff/');
    }

    /** @test */
    public function a_class_with_many_valid_methods_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('ValidClass.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_class_with_one_invalid_methods_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('InvalidClass.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_function_with_no_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('FunctionWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_function_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('FunctionWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_function_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('FunctionWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_function_with_two_levels_of_indentation_produces_an_error()
    {
        $results = $this->runner->sniff('FunctionWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_method_with_no_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('MethodWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_method_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('MethodWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_method_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('MethodWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_method_with_two_levels_of_indentation_produces_an_error()
    {
        $results = $this->runner->sniff('MethodWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_closure_with_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('ClosureWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_closure_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('ClosureWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_closure_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('ClosureWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_closure_with_two_levels_of_indentation_produces_an_error()
    {
        $results = $this->runner->sniff('ClosureWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_switch_with_no_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_with_two_levels_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_switch_in_a_function_with_no_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInFunctionWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_function_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInFunctionWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_function_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInFunctionWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_function_with_two_levels_of_indentation_produces_an_error()
    {
        $results = $this->runner->sniff('SwitchStatementInFunctionWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_switch_in_a_method_with_no_code_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInMethodWithNoCode.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_method_with_no_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInMethodWithNoIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_method_with_one_level_of_indentation_produces_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('SwitchStatementInMethodWithOneIndentation.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_switch_in_a_method_with_two_levels_of_indentation_produces_an_error()
    {
        $results = $this->runner->sniff('SwitchStatementInMethodWithTwoIndentation.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertAllEqual('2 indentation levels found. Maximum of 1 indentation levels allowed.', $errorMessages);
    }

    /** @test */
    public function a_try_catch_with_an_if_in_try_does_not_produce_an_error()
    {
        $results = $this->runner->sniff('TryCatchWithIfInTry.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }

    /** @test */
    public function a_try_catch_with_an_if_in_catch_does_not_produce_an_error()
    {
        $results = $this->runner->sniff('TryCatchWithIfInCatch.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }
}
