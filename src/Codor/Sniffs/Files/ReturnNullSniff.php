<?php declare(strict_types = 1);

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class ReturnNullSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_RETURN];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param integer              $stackPtr  The position in the stack where
     *                                    the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $returnTokenIndex = $stackPtr;

        $scope = array_slice($tokens, $returnTokenIndex, null, true);
        $semicolons = array_filter($scope, function ($token) {
            return $token['type'] === 'T_SEMICOLON';
        });

        $returnValueIndex = key($semicolons) - 1;
        $comparisonIndex = key($semicolons) - 3;

        if ($scope[$returnValueIndex]['type'] === 'T_NULL' && $this->isComparisonType($scope[$comparisonIndex]['type']) === false) {
            $error = "Return null value found.";
            $phpcsFile->addError($error, $returnValueIndex, __CLASS__);
        }
    }

    private function isComparisonType(string $type) : bool
    {
        return in_array($type, ['T_IS_NOT_IDENTICAL', 'T_IS_IDENTICAL', 'T_IS_NOT_EQUAL', 'T_IS_EQUAL'], true);
    }
}
