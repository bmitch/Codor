<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Syntax;

use Codor\Tests\BaseTestCase;

/** @group Syntax */
class LinesAfterMethodSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Syntax.LinesAfterMethod')->setFolder(__DIR__.'/Assets/LinesAfterMethodSniff/');
    }

    /** @test */
    public function by_default_only_allows_for_once_line_after_a_method()
    {
        $results = $this->runner->sniff('MethodThatHasMoreThanOneLine.inc');
        $this->assertEquals(2, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertAllEqual('No more than 1 line after a method/function is allowed.', $errorMessages);
    }

    /** @test */
    public function it_does_not_detect_any_errors_when_all_methods_have_only_one_line_between()
    {
        $results = $this->runner->sniff('MethodsAllHaveOneLineBetween.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    /** @test */
    public function it_works_with_interfaces()
    {
        $results = $this->runner->sniff('Interface.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    /** @test */
    public function it_does_not_detect_any_errors_when_a_function_follows_a_class()
    {
        $results = $this->runner->sniff('ClassAndFunction.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }
}
