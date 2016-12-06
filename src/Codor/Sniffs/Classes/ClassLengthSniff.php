<?php

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ClassLengthSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The maximum number of lines a class
     * should have.
     * @var integer
     */
    protected $maxLength = 200;

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
    {
        return [T_CLASS];
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
        $token = $tokens[$stackPtr];
        
        $openParenthesis = $tokens[$token['scope_opener']];
        $closedParenthesis = $tokens[$token['scope_closer']];

        $length = $closedParenthesis['line'] - $openParenthesis['line'];

        if ($length > $this->maxLength) {
            $phpcsFile->addError("Class is {$length} lines. Must be {$this->maxLength} lines or fewer.", $stackPtr);
        }
    }
}
