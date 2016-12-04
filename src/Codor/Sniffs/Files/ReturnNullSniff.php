<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ReturnNullSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
    {
        return [T_RETURN];
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
        $returnTokenIndex = $stackPtr;

        $returnValueToken = '';
        for ($index = $returnTokenIndex; $index < count($tokens); $index++) {
            if ($tokens[$index]['type'] === 'T_SEMICOLON') {
                $returnValueToken = $tokens[$index - 1];
                break;
            }
        }

        if ($returnValueToken == '') {
            return;
        }

        if ($returnValueToken['type'] === 'T_NULL') {
            $error = "Return null value found.";
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}
