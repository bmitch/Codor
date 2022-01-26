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
    public function a_no_di_injection_and_use_new_instance_keyword()
    {
        $results = $this->runner->sniff('NewInConstructor.inc');

        $this->assertSame(0, $results->getErrorCount());
        $this->assertSame(1, $results->getWarningCount());

        $warningMessages = $results->getAllWarningMessages();
        $this->assertCount(1, $warningMessages);
        $this->assertSame('Function __construct use new keyword - consider to use DI.', $warningMessages[0]);

    }
}
