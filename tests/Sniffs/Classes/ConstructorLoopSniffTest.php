<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class ConstructorLoopSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.ConstructorLoop')->setFolder(__DIR__.'/Assets/ConstructorLoopSniff/');
    }

    /** @test */
    public function if_constructor_has_no_loops_then_no_errors_generated()
    {
        $results = $this->runner->sniff('ConstructorWithNoLoop.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }

    /** @test */
    public function if_constructor_has_a_for_loop_an_error_is_generated()
    {
        $results = $this->runner->sniff('ConstructorWithForLoop.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class constructor cannot contain a loop.', $errorMessages);
    }

    /** @test */
    public function if_constructor_has_a_foreach_loop_an_error_is_generated()
    {
        $results = $this->runner->sniff('ConstructorWithForEachLoop.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class constructor cannot contain a loop.', $errorMessages);
    }

    /** @test */
    public function if_constructor_has_a_while_loop_an_error_is_generated()
    {
        $results = $this->runner->sniff('ConstructorWithWhileLoop.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class constructor cannot contain a loop.', $errorMessages);
    }

    /** @test */
    public function if_constructor_has_a_do_while_loop_an_error_is_generated()
    {
        $results = $this->runner->sniff('ConstructorWithDoWhileLoop.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class constructor cannot contain a loop.', $errorMessages);
    }

    /** @test */
    public function it_does_not_error_out_when_sniffing_an_interface()
    {
        $results = $this->runner->sniff('Interface.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }
}
