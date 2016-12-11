<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class IndentationLevelSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Indentations cannot be >= to this number.
     * @var integer
     */
    public $indentationLimit = 2;

    /**
     * The highest indentation level found.
     * @var integer
     */
    protected $maxIndentationFound;

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
    {
        return [T_FUNCTION, T_CLOSURE, T_SWITCH];
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
        $this->maxIndentationFound = 0;

        // Ignore functions with no body
        if (isset($token['scope_opener']) === false) {
            return;
        }

        $this->inspectScope($token, $tokens);

        if ($this->maxIndentationFound <= $this->indentationLimit) {
            return;
        }

        $phpcsFile->addError($this->getErrorMessage(), $stackPtr);
    }

    /**
     * Inspect the tokens in the scope of the provided $token.
     * @codingStandardsIgnoreStart
     * @param  array $token  Token Data.
     * @param  array $tokens Tokens.
     * @return void
     */
    protected function inspectScope(array $token, array $tokens)
    {
        $start = $token['scope_opener'];
        $end = $token['scope_closer'];
        $this->relativeScopeLevel = $tokens[$start]['level'];
        for ($index=$start; $index <= $end; $index++) {
            $nestedToken = $tokens[$index];
            if ($nestedToken['type'] === "T_SWITCH") {
                return;
            }
            $this->adjustMaxIndentationFound($nestedToken);
        }
    }
    // @codingStandardsIgnoreEnd

    /**
     * Adjust the maximum indentation level found value.
     * @param  array $nestedToken Token data.
     * @return void
     */
    protected function adjustMaxIndentationFound(array $nestedToken)
    {
        $tokenNestedLevel = $nestedToken['level'];
        $nestedLevel = $tokenNestedLevel - $this->relativeScopeLevel;
        $nestedLevel > $this->maxIndentationFound ? $this->maxIndentationFound = $nestedLevel : null;
    }

    /**
     * Produce the error message.
     * @return string
     */
    protected function getErrorMessage()
    {
        // Hack to fix the output numbers for the
        // indentation levels found and the
        // indentation limit.
        $indentationFound = $this->maxIndentationFound - 1;
        $indentationLimit = $this->indentationLimit - 1;
        return "{$indentationFound} indenation levels found. " .
        "Maximum of {$indentationLimit} indenation levels allowed.";
    }
}
