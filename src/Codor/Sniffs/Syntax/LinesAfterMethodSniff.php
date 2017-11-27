<?php declare(strict_types = 1);

namespace Codor\Sniffs\Syntax;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class LinesAfterMethodSniff implements PHP_CodeSniffer_Sniff
{

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
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param integer              $stackPtr  The position in the stack where
     *                                    the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (! isset($tokens[$stackPtr]['scope_closer'])) {
            return;
        }

        $endOfMethodIndex = $tokens[$stackPtr]['scope_closer'];

        for ($index=$endOfMethodIndex + 1; $index <= count($tokens); $index++) {
            if ($tokens[$index]['type'] !== 'T_WHITESPACE') {
                $nextCodeLine = $tokens[$index]['line'];
                break;
            }
        }

        $linesBetween = $nextCodeLine - $tokens[$endOfMethodIndex]['line'] - 1;

        if ($linesBetween > 1) {
            $phpcsFile->addError("No more than 1 line after a method/function is allowed.", $stackPtr, __CLASS__);
        }
    }
}
