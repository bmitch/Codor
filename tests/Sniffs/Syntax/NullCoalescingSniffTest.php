<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Syntax;

use Codor\Tests\BaseTestCase;

/** @group Syntax */
class NullCoalescingSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Syntax.NullCoalescing')->setFolder(__DIR__.'/Assets/NullCoalescingSniff/');
    }

    /** @test */
    public function it_correctly_detects_when_a_ternary_could_be_a_null_coalescing()
    {
        $results = $this->runner->sniff('TernaryThatCanBeNullCoalescing.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Ternery found where Null Coalescing operator will work.', $errorMessages);
    }

    /** @test */
    public function it_correctly_detects_when_a_ternary_cant_be_a_null_coalescing()
    {
        $results = $this->runner->sniff('TernaryThatCannotBeNullCoalescing.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

}
