<?php

namespace Codor\Tests;

use PHP_CodeSniffer;

class CodeSnifferRunner
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    public function __construct()
    {
        $this->codeSniffer = new PHP_CodeSniffer();
    }

    public function detectErrorCountInFileForSniff($testedFile, $sniffName)
    {
        return $this->processCodeSniffer($testedFile, $sniffName)->getErrorCount();
    }

    public function detectWarningCountInFileForSniff($testedFile, $sniffName)
    {
        return $this->processCodeSniffer($testedFile, $sniffName)->getWarningCount();
    }

    private function processCodeSniffer($testedFile, $sniffName)
    {
        $this->codeSniffer->initStandard(__DIR__.'/../src/Codor', [$sniffName]);

        return $this->codeSniffer->processFile($testedFile);
    }
}