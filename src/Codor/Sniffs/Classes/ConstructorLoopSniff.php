<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ConstructorLoopSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The loop tokens we're lookin for.
     * @var array
     */
    protected $loops = ['T_FOR', 'T_FOREACH', 'T_WHILE'];

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
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens            = $phpcsFile->getTokens();
        $token             = $tokens[$stackPtr];
        $functionNameToken = $tokens[$stackPtr + 2];
        $functionName      = $functionNameToken['content'];
        if ($functionName !== '__construct') {
            return;
        }

        $startIndex   = $token['scope_opener'];
        $endIndex = $token['scope_closer'];

        for ($index=$startIndex; $index <= $endIndex; $index++) {
            if (in_array($tokens[$index]['type'], $this->loops)) {
                $phpcsFile->addError("Class constructor cannot contain a loop.", $stackPtr);
                continue;
            }
        }
    }
}
