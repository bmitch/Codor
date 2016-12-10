<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class FunctionParameterSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The maximum number of parameters a function can have.
     * @var integer
     */
    public $maxParameters = 3;

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

        $numberOfParameters = 0;
        for ($index=$openParenIndex+1; $index <= $closedParenIndex; $index++) {
            if ($tokens[$index]['type'] == 'T_VARIABLE') {
                $numberOfParameters++;
            }
        }

        if ($numberOfParameters > $this->maxParameters) {
            $phpcsFile->addError("Function has more than {$this->maxParameters} parameters. Please reduce.", $stackPtr);
        }

        if ($numberOfParameters == $this->maxParameters) {
            $phpcsFile->addWarning("Function has {$this->maxParameters} parameters.", $stackPtr);
        }
    }
}
