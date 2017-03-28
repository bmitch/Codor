<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class MethodFlagParameterSniff implements PHP_CodeSniffer_Sniff
{

    protected $booleans = ['T_FALSE', 'T_TRUE'];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
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
        $tokens           = $phpcsFile->getTokens();

        $token            = $tokens[$stackPtr];
        $openParenIndex   = $token['parenthesis_opener'];
        $closedParenIndex = $token['parenthesis_closer'];

        for ($index=$openParenIndex+1; $index <= $closedParenIndex; $index++) {
            if (in_array($tokens[$index]['type'], $this->booleans)) {
                $phpcsFile->addError("Function/method contains a flag parameter.", $stackPtr);
                continue;
            }
        }
    }
}
