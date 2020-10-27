<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
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
    protected $protectedMethodTokens = [];

    /**
     * List of protected variables found.
     * @var array
     */
    protected $protectedVariableTokens = [];

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
        $this->classIsMarkedFinal = false;
        $this->protectedMethodTokens = [];
        $this->protectedVariableTokens = [];

        $tokens = $phpcsFile->getTokens();

        foreach ($tokens as $index => $token) {
            $this->handleToken($tokens, $index);
        }

        $this->handleErrors($phpcsFile);
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
            $this->protectedVariableTokens[] = $tokens[$index+2];
            return;
        }

        $this->protectedMethodTokens[] = $tokens[$index+4];
    }

    /**
     * Handle any errors.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @return void
     */
    protected function handleErrors($phpcsFile)
    {
        foreach ($this->protectedMethodTokens as $protectedMethodToken) {
            $this->handleProtectedMethodToken($protectedMethodToken, $phpcsFile);
        }

        foreach ($this->protectedVariableTokens as $protectedVariableToken) {
            $this->handleProtectedVariableToken($protectedVariableToken, $phpcsFile);
        }
    }

    /**
     * Add a protected method found error.
     * @param  array                $token     Token data.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @return void
     */
    protected function handleProtectedMethodToken($token, $phpcsFile)
    {
        $methodName = $token['content'];
        $line = $token['line'];
        $phpcsFile->addError("Final Class contains a protected method {$methodName} - should be private.", $line, __CLASS__);
    }

    /**
     * Add a protected variable found error.
     * @param  array                $token     Token data.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @return void
     */
    protected function handleProtectedVariableToken($token, $phpcsFile)
    {
        $variableName = $token['content'];
        $line = $token['line'];
        $phpcsFile->addError("Final Class contains a protected variable {$variableName} - should be private.", $line, __CLASS__);
    }
}
