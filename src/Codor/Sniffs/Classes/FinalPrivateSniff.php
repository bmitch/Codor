<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class FinalPrivateSniff implements PHP_CodeSniffer_Sniff
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
     * Is the class marked as final?
     * @var boolean
     */
    protected $classIsMarkedFinal = false;

    /**
     * List of protected methods found.
     * @var array
     */
    protected $protectedMethods = [];

    /**
     * List of protected variables found.
     * @var array
     */
    protected $protectedVariables = [];

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     * @return void
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        foreach ($tokens as $index => $token) {
            $this->handleToken($tokens, $index);
        }

        $this->handleErrors($phpcsFile, $stackPtr);
    }

    /**
     * Handle the incoming token.
     * @param  array   $tokens List of tokens.
     * @param  integer $index  Current token index.
     * @return void
     */
    protected function handleToken($tokens, $index)
    {
        $tokenType = $tokens[$index]['type'];

        if ($tokenType === 'T_FINAL') {
            $this->classIsMarkedFinal = true;
            return;
        }

        if (! $this->classIsMarkedFinal) {
            return;
        }

        if ($tokenType !== 'T_PROTECTED') {
            return;
        }
        
        $this->handleFoundProtectedElement($tokens, $index);
    }

    /**
     * Handles found protected method or variable within
     * a final class.
     * @param  array   $tokens List of tokens.
     * @param  integer $index  Current token index.
     * @return void
     */
    protected function handleFoundProtectedElement($tokens, $index)
    {
        $type = $tokens[$index+2]['type'];

        if ($type === 'T_VARIABLE') {
            $variableName = $tokens[$index+2]['content'];
            $this->protectedVariables[] = $variableName;
            return;
        }

        $methodName = $tokens[$index+4]['content'];
        $this->protectedMethods[] = $methodName;
    }

    /**
     * Handle any errors.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where.
     * @return void
     */
    protected function handleErrors($phpcsFile, $stackPtr)
    {
        foreach ($this->protectedMethods as $protectedMethod) {
            $this->handleProtectedMethod($protectedMethod, $phpcsFile, $stackPtr);
        }

        foreach ($this->protectedVariables as $protectedVariable) {
            $this->handleProtectedVariable($protectedVariable, $phpcsFile, $stackPtr);
        }
    }

    /**
     * Add a protected method found error.
     * @param  string               $method    Name of the method found.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where.
     * @return void
     */
    protected function handleProtectedMethod($method, $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError("Final Class contains a protected method {$method} - should be private.", $stackPtr);
    }

    /**
     * Add a protected variable found error.
     * @param  string               $variable  Name of the variable found.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where.
     * @return void
     */
    protected function handleProtectedVariable($variable, $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError("Final Class contains a protected variable {$variable} - should be private.", $stackPtr);
    }
}
