<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class FinalPrivateSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.FinalPrivate')->setFolder(__DIR__.'/Assets/FinalPrivateSniff/');
    }

    /** @test */
    public function a_final_class_with_no_protected_methods_or_members_throws_no_errors_or_warnings()
    {
        $results = $this->runner->sniff('FinalClassWithNoProtectedMethodsOrMembers.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    /** @test */
    public function a_final_class_with_a_protected_methods_throws_an_error()
    {
        $results = $this->runner->sniff('FinalClassWithOneProtectedMethod.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Final Class contains a protected method foobar - should be private.', $errorMessages);
    }

    /** @test */
    public function a_final_class_with_two_protected_methods_throws_two_errors()
    {
        $results = $this->runner->sniff('FinalClassWithTwoProtectedMethods.inc');
        $this->assertSame(2, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(2, $errorMessages);
        $this->assertEquals('Final Class contains a protected method foobar - should be private.', $errorMessages[0]);
        $this->assertEquals('Final Class contains a protected method baz - should be private.', $errorMessages[1]);
    }

    /** @test */
    public function a_final_class_with_a_protected_variable_throws_an_error()
    {
        $results = $this->runner->sniff('FinalClassWithOneProtectedVariable.inc');

        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Final Class contains a protected variable $baz - should be private.', $errorMessages);
    }
}
