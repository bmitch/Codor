<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\ControlStructures;

use Codor\Tests\BaseTestCase;

/** @group ControlStructures */
class NoControlStructuresSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.ControlStructures.NoControlStructures')->setFolder(__DIR__.'/Assets/NoControlStructures/');
    }

    /** @test */
    public function it_detects_if_a_file_has_an_if_statement()
    {
        $results = $this->runner->sniff('FileWithIf.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_an_else_statement()
    {
        $results = $this->runner->sniff('FileWithIfElse.inc');
        $this->assertSame(4, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(4, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_a_switch_statement()
    {
        $results = $this->runner->sniff('FileWithSwitch.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_a_while_loop()
    {
        $results = $this->runner->sniff('FileWithWhileLoop.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_a_do_while_loop()
    {
        $results = $this->runner->sniff('FileWithDoWhileLoop.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_a_for_loop()
    {
        $results = $this->runner->sniff('FileWithForLoop.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }

    /** @test */
    public function it_detects_if_a_file_has_a_foreach_loop()
    {
        $results = $this->runner->sniff('FileWithForEachLoop.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('Do not use control structures or loops in this file.', $errorMessages);
    }
}
