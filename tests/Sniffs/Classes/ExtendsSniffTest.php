<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class ExtendsSniffTest extends BaseTestCase
{
    public function setup()
    {
        parent::setup();
        $this->runner->setSniff('Codor.Classes.Extends')->setFolder(__DIR__.'/Assets/ExtendsSniff/');
    }

    /** @test */
    public function a_class_that_does_not_extend_does_not_throw_a_warning()
    {
        $results = $this->runner->sniff('ClassThatDoesNotExtend.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    /** @test */
    public function a_class_that_extends_another_throws_a_warning()
    {
        $results = $this->runner->sniff('ClassThatExtendsAnotherClass.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
        $this->assertSame('Class extends another class - consider composition over inheritance.', $warningMessages[0]);
    }

}
