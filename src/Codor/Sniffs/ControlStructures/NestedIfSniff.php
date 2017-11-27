<?php declare(strict_types = 1);

namespace Codor\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NestedIfSniff implements Sniff
{

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_IF];
    }

    /**
     * The PHP Code Sniffer file.
     * @var PHP_CodeSniffer_File
     */
    protected $phpcsFile;

    /**
     * The list of errors encountered;
     * @var array
     */
    protected $errorStack;

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
        $this->phpcsFile = $phpcsFile;
        $tokens          = $phpcsFile->getTokens();
        $token           = $tokens[$stackPtr];
        $start           = $token['scope_opener'];
        $end             = $token['scope_closer'];

        $this->errorStack = [];
        for ($index=$start; $index <= $end; $index++) {
            $this->checkForNestedIf($tokens[$index], $stackPtr);
        }
    }

    /**
     * Check to see if the $token is a nested if statement.
     * @param  array   $token    Current Token.
     * @param  integer $stackPtr The position in the stack where the token was found.
     * @return void
     */
    protected function checkForNestedIf(array $token, int $stackPtr)
    {
        if (! $this->isIfStatement($token)) {
            return;
        }

        if ($this->errorAlreadyAdded($stackPtr)) {
            return;
        }

        $this->phpcsFile->addError('Nested if statement found.', $stackPtr, __CLASS__);
        $this->errorStack[] = $stackPtr;
    }

    /**
     * Checks to see if this position in the stack
     * has already had an error reported.
     * @param  integer $stackPtr The position in the stack where the token was found.
     * @return boolean
     */
    protected function errorAlreadyAdded(int $stackPtr): bool
    {
        if (in_array($stackPtr, $this->errorStack)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the proved token is an if statement.
     * @param  array $token Token data.
     * @return boolean
     */
    protected function isIfStatement(array $token): bool
    {
        if ($token['type'] === 'T_IF') {
            return true;
        }

        return false;
    }
}
