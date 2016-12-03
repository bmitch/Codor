<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/** @group Files */
class FunctionLengthSniffTest extends TestCase
{
	/** @test */
    public function it_detects_functions_that_are_over_the_max_allowed()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/Assets/FunctionLengthSniff/FunctionLengthSniff.inc',
            'Codor.Files.FunctionLength'
        );

        $this->assertSame(2, $errorCount);
    }
}