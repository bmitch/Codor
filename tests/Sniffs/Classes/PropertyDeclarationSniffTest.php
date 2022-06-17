<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class PropertyDeclarationSniffTest extends BaseTestCase
{

    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.PropertyDeclaration')->setFolder(__DIR__.'/Assets/PropertyDeclarationSniff/');
    }

    /** @test */
    public function it_produces_an_error_when_a_class_has_one_undeclared_property()
    {
        $results = $this->runner->sniff('ClassWithOneUndeclaredProperty.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class contains undeclared property baz.', $errorMessages);
    }

    /** @test */
    public function it_produces_no_errors_when_a_class_has_no_undeclared_property()
    {
        $results = $this->runner->sniff('ClassWithNoUndeclaredProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }

    /** @test */
    public function it_produces_no_errors_when_a_class_has_one_declared_public_property()
    {
        $results = $this->runner->sniff('ClassWithOneDeclaredPublicProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }

    /** @test */
    public function it_produces_no_errors_when_a_class_has_one_declared_private_property()
    {
        $results = $this->runner->sniff('ClassWithOneDeclaredPrivateProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }

    /** @test */
    public function it_produces_no_errors_when_a_class_has_one_declared_protected_property()
    {
        $results = $this->runner->sniff('ClassWithOneDeclaredProtectedProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }

    /** @test */
    public function it_works_on_a_class_with_some_declared_and_undeclared_properties()
    {
        $results = $this->runner->sniff('ClassWithSomeDeclaredAndUndeclaredProperties.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual('Class contains undeclared property bop.', $errorMessages);
    }

    /** @test */
    public function it_produces_a_warning_when_a_class_has_one_undeclared_property_but_class_is_child_class()
    {
        $results = $this->runner->sniff('ExtendedClassWithOneUndeclaredProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
        $this->assertAllEqual('Class contains undeclared property baz.', $warningMessages);
    }

    /** @test */
    public function it_produces_no_errors_when_a_class_has_one_typed_property()
    {
        $results = $this->runner->sniff('ClassWithOneDeclaredTypedProperty.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
    }
}
