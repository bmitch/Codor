<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class ClassNameInConstructorSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param integer              $stackPtr  The position in the stack where the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $classname = $phpcsFile->getTokens()[$stackPtr + 2]['content'];
        $constructorDocblockText = '';

        foreach ($phpcsFile->getTokens() as $token) {
            if (strpos($token['content'], 'constructor')) {
                $constructorDocblockText = explode(' ', $token['content'])[0];
            }
        }

        if ($constructorDocblockText === '') {
            return;
        }

        if ($classname !== $constructorDocblockText) {
            $phpcsFile->addError("Class name should match class name declaration in constructor docblock \n Class name: {$classname} \n Constructor Defined Class {$constructorDocblockText}", $stackPtr, __CLASS__);
        }
    }
}
