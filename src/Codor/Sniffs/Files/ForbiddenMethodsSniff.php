<?php declare(strict_types = 1);

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ForbiddenMethodsSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * The methods that are forbidden.
     * @var array
     */
    public $forbiddenMethods = ['raw', 'statement'];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_OBJECT_OPERATOR, T_DOUBLE_COLON];
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
        $potentialMethodToken = $tokens[$stackPtr + 1];
        $openParenToken = $tokens[$stackPtr + 2];

        if ($openParenToken['type'] !== 'T_OPEN_PARENTHESIS') {
            return;
        }

        $methodName = $potentialMethodToken['content'];
        if (in_array($methodName, $this->forbiddenMethods, true)) {
            $phpcsFile->addError("Call to method {$methodName} is forbidden.", $potentialMethodToken['line']);
        }
    }
}
