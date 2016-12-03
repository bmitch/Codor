<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class FunctionLengthSniff implements PHP_CodeSniffer_Sniff
{

    protected $maxLength = 20;

    public function register()
    {
        return [T_FUNCTION];
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // Skip function without body.
        if (isset($token['scope_opener']) === false) {
            return 0;
        }

        $firstToken = $tokens[$token['scope_opener']];
        $lastToken = $tokens[$token['scope_closer']];
        $length = $lastToken['line'] - $firstToken['line'];

        if ($length > $this->maxLength) {
            $tokenType = strtolower(substr($token['type'], 2));
            $error = "Function is {$length} lines. Must be {$this->maxLength} lines or fewer.";
            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooBig', ucfirst($tokenType)));
        }
    }
}
