<?php

namespace Codor\Sniffs\ControlStructures;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Do not use "else" or "elseif".
 */
class NoElseSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return [T_ELSE, T_ELSEIF];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError('Do not use "else" or "elseif"', $stackPtr);
    }
}