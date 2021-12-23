<?php declare(strict_types = 1);

namespace Codor\Tests\Sniffs\Files;

use Codor\Tests\BaseTestCase;

/** @group Files */
class NotReturnNullIfComparaisonWithNullSniffTest extends BaseTestCase
{

    /**
     * Sets up the test class.
     * @return void
     */
    public function setup()
    {
        parent::setup();

        $this->runner->setSniff('Codor.Files.ReturnNull')->setFolder(__DIR__.'/Assets/ReturnNullSniff/');
    }

    /** @test */
    public function it_detects_functions_that_return_not_null_if_comparaison_with_null()
    {
        $results = $this->runner->sniff('FunctionNotReturnNullIfComparaisonWithNull.inc');
        $this->assertEquals(0, $results->getErrorCount());
        $this->assertEquals(0, $results->getWarningCount());

        $errorMessages = $results->getAllErrorMessages();
        $this->assertCount(0, $errorMessages);
        $this->assertAllEqual('Return null value found.', $errorMessages);
    }
}
