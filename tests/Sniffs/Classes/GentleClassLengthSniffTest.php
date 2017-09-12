<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class GentleClassLengthSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.GentleClassLength')->setFolder(__DIR__.'/Assets/GentleClassLengthSniff/');
    }

    /** @test */
    public function it_correctly_identifies_a_class_with_over_100_logical_lines_of_code()
    {
        $results = $this->runner->sniff('Over100LogicalLines.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class has 102 logical lines of code. Must be 100 lines or fewer.', $errorMessages);
    }

    /** @test */
    public function it_correctly_identifies_a_class_with_under_100_logical_lines_of_code_but_more_than_100_lines_total()
    {
        $results = $this->runner->sniff('Under100LogicalLines.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }
}
