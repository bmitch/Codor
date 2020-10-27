<?php declare(strict_types = 1);

namespace Codor\Tests;

use Codor\Tests\Wrappers\Results as ResultsWrapper;
use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Reporter;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Runner as  PHP_CodeSniffer;

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
        Config::setConfigData('report_format', 'full');

        $_SERVER['argv'] = ['-v']; // fix to avoid an Undefined constant error from the Config object (could be improved)
        $this->codeSniffer = new PHP_CodeSniffer();
        $this->codeSniffer->config = new Config();

        $this->codeSniffer->reporter = new Reporter($this->codeSniffer->config);

        $this->codeSniffer->init(); // Eventually constants not defined properly
    }

    /**
     * Sets the sniff we will test.
     * @param string $sniff The sniff to test.
     * @return CodeSnifferRunner
     */
    public function setSniff(string $sniff): CodeSnifferRunner
    {
        $this->sniff = $sniff;

        return $this;
    }

    /**
     * Sets the folder the sample files live in.
     * @param string $path Path to sample files.
     * @return void
     */
    public function setFolder(string $path)
    {
        $this->path = $path;
    }

    /**
     * Sets the file to run the sniffer on then
     * calls the run method to run the sniffer.
     * @param  string $file Filename.
     * @return ResultsWrapper Sniffer Results.
     */
    public function sniff(string $file): ResultsWrapper
    {
        $this->filePath = $this->path . $file;

        return $this->run();
    }

	/**
	 * Runs the actual sniffer on the file.
	 * @return ResultsWrapper Sniffer Results.
	 */
	protected function run(): ResultsWrapper
	{
		$Config             = new Config();
		$Config->standards  = [__DIR__ . '/../src/Codor'];
		$Config->sniffs     = [$this->sniff];

		$Ruleset = new Ruleset($Config);

		$File = new File($this->filePath, $Ruleset, $Config);
		$File->setContent(file_get_contents($this->filePath)); // file set @ constructor but content didn't get (sic!)
		$this->codeSniffer->processFile($File);

		return new ResultsWrapper($File);
	}
}
