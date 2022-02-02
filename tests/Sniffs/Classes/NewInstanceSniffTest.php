<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class NewInstanceSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.NewInstance')->setFolder(__DIR__.'/Assets/NewInstanceSniff/');
    }

    /** @test */
    public function a_new_in_constructor_function()
    {
        $results = $this->runner->sniff('NewInConstructor.inc');

        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
        $this->assertSame('Function __construct use new keyword - consider to use DI.', $warningMessages[0]);
    }

    /** @test */
    public function a_new_not_in_function()
    {
        $results = $this->runner->sniff('NewNotInFunction.inc');

        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(0, $warningMessages);
    }

    /** @test */
    public function a_new_in_regular_function()
    {
        $results = $this->runner->sniff('NewInRegularFunction.inc');

        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
    }

    /** @test */
    public function a_multiple_new_in_class()
    {
        $results = $this->runner->sniff('MultipleNewInClass.inc');

        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(2, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(2, $warningMessages);
    }
}
