<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/** @group Files */
class FunctionParameterSniffTest extends TestCase
{
	/** @test */
    public function it_produces_an_error_when_a_function_has_4_or_more_parameters()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/Assets/FunctionParameterSniff/FunctionsWithFourOrMoreParameters.inc',
            'Codor.Files.FunctionParameter'
        );

        $this->assertSame(4, $errorCount);
    }

    /** @test */
    public function it_produces_a_warning_when_a_function_has_3_parameters()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $warningCount = $codeSnifferRunner->detectWarningCountInFileForSniff(
            __DIR__.'/Assets/FunctionParameterSniff/FunctionWithThreeParameters.inc',
            'Codor.Files.FunctionParameter'
        );

        $this->assertSame(2, $warningCount);
    }

    /** @test */
    public function it_produces_no_warnings_or_errors_with_functions_with_2_or_fewer_parameters()
    {
        $codeSnifferRunner = new CodeSnifferRunner();

        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/Assets/FunctionParameterSniff/FunctionWithTwoOrFewerParameters.inc',
            'Codor.Files.FunctionParameter'
        );

        $warningCount = $codeSnifferRunner->detectWarningCountInFileForSniff(
            __DIR__.'/Assets/FunctionParameterSniff/FunctionWithTwoOrFewerParameters.inc',
            'Codor.Files.FunctionParameter'
        );

        $this->assertSame(0, $errorCount);
        $this->assertSame(0, $warningCount);
    }
}