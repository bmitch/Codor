<?php

namespace Codor\Sniffs\ControlStructures;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Do not use "else" or "elseif".
 */
class NoElseSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
    {
        return [T_ELSE, T_ELSEIF];
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
        $phpcsFile->addError('Do not use "else" or "elseif"', $stackPtr);
    }
}
