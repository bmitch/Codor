<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class NewInstanceSniff implements PHP_CodeSniffer_Sniff
{
  /**
     * The forbidden strings this sniff looks for.
     * @var array
     */
    protected $keywords = ['And', '_and', 'Or', '_or'];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param integer              $stackPtr  The position in the stack where
     *                                    the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionName = $tokens[$stackPtr + 2]['content'];
        $token = $tokens[$stackPtr];
     
        $start = $token['scope_opener'];
        $end = $token['scope_closer'];

        foreach (range($start, $end) as $index) {
            if ($tokens[$index]['type'] === 'T_NEW') {
                $phpcsFile->addWarning($this->getWarningMessage($functionName), $tokens[$index]['line'], __CLASS__);
            }
        }
    }

    /**
     * Gets the warning message for this sniff.
     * @return string
     */
    protected function getWarningMessage(string $functionName): string
    {
        return sprintf('Function %s use new keyword - consider to use DI.', $functionName);
    }
}
