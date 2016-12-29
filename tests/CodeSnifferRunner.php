<?php

namespace Codor\Tests;

use Codor\Tests\Wrappers\Results as ResultsWrapper;
use PHP_CodeSniffer;

class CodeSnifferRunner
{
    /**
     * @var PHP_CodeSniffer
     */
    protected $codeSniffer;

    /**
     * The current sniff rule being tested.
     * @var string
     */
    protected $sniff;

    /**
     * Path of the folder that will contain the file
     * to test against.
     * @var string
     */
    protected $path;

    /**
     * The file path to the file to test against.
     * @var string
     */
    protected $filePath;

    /**
     * Class Constructor.
     */
    public function __construct()
    {
        $this->codeSniffer = new PHP_CodeSniffer();
        $this->codeSniffer->setConfigData('report_format', 'full');
    }

    /**
     * Sets the sniff we will test.
     * @param string $sniff The sniff to test.
     * @return CodeSnifferRunner
     */
    public function setSniff($sniff)
    {
        $this->sniff = $sniff;

        return $this;
    }

    /**
     * Sets the folder the sample files live in.
     * @param string $path Path to sample files.
     * @return void
     */
    public function setFolder($path)
    {
        $this->path = $path;
    }

    /**
     * Sets the file to run the sniffer on then
     * calls the run method to run the sniffer.
     * @param  string $file Filename.
     * @return ResultsWrapper Sniffer Results.
     */
    public function sniff($file)
    {
        $this->filePath = $this->path . $file;

        return $this->run();
    }

    /**
     * Runs the actual sniffer on the file.
     * @return ResultsWrapper Sniffer Results.
     */
    protected function run()
    {
        $this->codeSniffer->initStandard(__DIR__.'/../src/Codor', [$this->sniff]);

        return new ResultsWrapper($this->codeSniffer->processFile($this->filePath));
    }
}
