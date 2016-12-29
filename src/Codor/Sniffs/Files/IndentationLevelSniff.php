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
     * @param  array $token  Token Data.
     * @param  array $tokens Tokens.
     * @return void
     */
    protected function inspectScope(array $token, array $tokens)
    {
        $start = $token['scope_opener'];
        $length = $token['scope_closer'] - $start + 1;
        $relativeScopeLevel = $tokens[$start]['level'];

        $scope = array_slice($tokens, $start, $length, true);
        $scope = $this->removeTokenScopes($scope, 'T_SWITCH');

        $this->maxIndentationFound = array_reduce($scope, function ($max, $nestedToken) use ($relativeScopeLevel) {
            $max = max($max, $nestedToken['level'] - $relativeScopeLevel);
            return $max;
        });
    }

    /**
     * Remove the bodies of given token type from the scope.
     * @param  array  $scope The tokens in a scope.
     * @param  string $type  The type of token to remove from the scope.
     * @return array  $scope The tokens scope without the removed tokens.
     */
    protected function removeTokenScopes(array $scope, $type)
    {
        $typeTokens = array_filter($scope, function ($token) use ($type) {
            return $token['type'] == $type;
        });

        foreach ($typeTokens as $token) {
            $range = array_flip(range($token['scope_opener'], $token['scope_closer']));
            $scope = array_diff_key($scope, $range);
        }

        return $scope;
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
        return "{$indentationFound} indentation levels found. " .
        "Maximum of {$indentationLimit} indentation levels allowed.";
    }
}
