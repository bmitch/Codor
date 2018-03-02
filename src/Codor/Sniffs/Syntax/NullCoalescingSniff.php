<?php declare(strict_types = 1);

namespace Codor\Sniffs\Syntax;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class NullCoalescingSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_ISSET];
    }

    /**
     * The PHP Code Sniffer file.
     * @var PHP_CodeSniffer_File
     */
    protected $phpcsFile;

    /**
     * Processes the tokens that this sniff is interested in.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param integer              $stackPtr  The position in the stack where
     *                                    the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $tokens          = $phpcsFile->getTokens();
        $index           = $stackPtr;

        if ($this->couldBeNullCoalescing($tokens, $index)) {
            $phpcsFile->addError("Ternery found where Null Coalescing operator will work.", $stackPtr, __CLASS__);
        }
    }

    /**
     * Determines if the current line has a ternary
     * operator that could be converted to a
     * null coalescing operator.
     * @param  array   $tokens Tokens.
     * @param  integer $index  Current index.
     * @return boolean
     */
    protected function couldBeNullCoalescing($tokens, $index): bool
    {
        $questionMarkFound = false;
        $semiColinFound = false;

        while (true) {
            if ($tokens[$index]['type'] == 'T_SEMICOLON') {
                break;
            }

            if ($tokens[$index]['type'] == 'T_INLINE_THEN') {
                $questionMarkFound = true;
            }

            if ($tokens[$index]['type'] == 'T_INLINE_ELSE') {
                $semiColinFound = true;
            }
            $index++;
        }

        return $questionMarkFound && $semiColinFound;
    }
}
