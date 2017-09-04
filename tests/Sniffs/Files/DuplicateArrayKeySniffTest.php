<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Files;

use Codor\Tests\BaseTestCase;

/** @group Files */
class DuplicateArrayKeySniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.DuplicateArrayKey')->setFolder(__DIR__.'/Assets/DuplicateArrayKeySniff/');
    }

    /** @test */
    public function it_detects_no_errors_for_an_array_with_no_duplicate_keys()
    {
        $results = $this->runner->sniff('ArraysWithNoDuplicateKeys.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());
    }


    /** @test */
    public function it_detects_an_array_declared_the_old_way_with_a_duplicate_string_key()
    {
        $results = $this->runner->sniff('OldArrayWithDuplicateStringKey.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Array contains a duplicate key: 'foo'.", $errorMessages);
    }

    /** @test */
    public function it_detects_an_array_declared_the_old_way_with_a_duplicate_int_key()
    {
        $results = $this->runner->sniff('OldArrayWithDuplicateIntKey.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Array contains a duplicate key: 0.", $errorMessages);
    }

    /** @test */
    public function it_detects_an_array_declared_the_new_way_with_a_duplicate_string_key()
    {
        $results = $this->runner->sniff('NewArrayWithDuplicateStringKey.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Array contains a duplicate key: 'foo'.", $errorMessages);
    }

    /** @test */
    public function it_detects_an_array_declared_the_new_way_with_a_duplicate_int_key()
    {
        $results = $this->runner->sniff('NewArrayWithDuplicateIntKey.inc');
        $this->assertEquals(1, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(1, $errorMessages);
        $this->assertAllEqual("Array contains a duplicate key: 0.", $errorMessages);
    }
}
