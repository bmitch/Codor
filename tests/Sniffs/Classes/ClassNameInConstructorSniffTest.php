<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Classes;

use Codor\Tests\BaseTestCase;

/** @group Classes */
class ClassNameInConstructorSniffTest extends BaseTestCase
{
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Classes.ClassNameInConstructor')->setFolder(__DIR__.'/Assets/ClassNameInConstructorSniff/');
    }

    public function test_fails_if_constructor_name_does_not_match_doc_block_class_declaration()
    {
        $results = $this->runner->sniff('ClassNameMismatchInConstructorSniff.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
        
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Class name should match class name declaration in constructor docblock \n Class name: TestNameDoesNotMatch \n Constructor Defined Class NameDoesntMatch", $errorMessages);
    }

    public function test_fails_if_constructor_name_does_not_match_doc_block_class_declaration_where_space_format_is_different()
    {
        $results = $this->runner->sniff('ClassNameMismatchConstructorSpacedFormatSniff.inc');
        $this->assertSame(1, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
        
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Class name should match class name declaration in constructor docblock \n Class name: TestNameDoesNotMatch \n Constructor Defined Class NameDoesntMatch", $errorMessages);
    }

    public function test_does_not_fail_if_there_is_no_constructor()
    {
        $results = $this->runner->sniff('NoConstructorSniff.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
        
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    }

    public function test_does_not_fail_if_there_is_constructor_matches_docblock()
    {
        $results = $this->runner->sniff('ClassNameMatchInConstructorSniff.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
        
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    } 

    public function test_does_not_fail_if_there_is_it_is_an_empty_class()
    {
        $results = $this->runner->sniff('EmptyClass.inc');
        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(0, $results->getWarningCount());
        
        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
    } 
}