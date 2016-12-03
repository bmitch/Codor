<?php

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;


class NoElseSniffTest extends TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/NoElseSniffTest.inc',
            'Codor.ControlStructures.NoElse'
        );

        $this->assertSame(5, $errorCount);
    }
}