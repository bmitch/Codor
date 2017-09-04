<?php declare(strict_types = 1);

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class DuplicateArrayKeySniff implements PHP_CodeSniffer_Sniff
{

    private $keysFound = [];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_ARRAY, T_OPEN_SHORT_ARRAY];
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
        $this->keysFound = [];

        $tokens = $phpcsFile->getTokens();
            dd($tokens);
        $arrayTokenIndex = $stackPtr;

        $scope = array_slice($tokens, $arrayTokenIndex, null, true);

        $tokensToProcess = [];

        foreach ($scope as $key => $token) {
            if (! in_array($token['type'], ['T_OPEN_SHORT_ARRAY', 'T_ARRAY'])) {
                continue;
            }
            $tokensToProcess[] = $token;

//            if ($token['type'] === 'T_ARRAY') {
//                unset($scope[$key]);
//            }
//
//            if ($token['type'] === 'T_WHITESPACE') {
//                unset($scope[$key]);
//            }
//
//            if ($token['type'] === 'T_OPEN_PARENTHESIS') {
//                unset($scope[$key]);
//            }
//
//            if ($token['type'] === 'T_CLOSE_PARENTHESIS') {
//                unset($scope[$key]);
//            }
//
//            if ($token['type'] === 'T_SEMICOLON') {
//                unset($scope[$key]);
//            }
//
//            if ($token['type'] === 'T_CLOSE_CURLY_BRACKET') {
//                unset($scope[$key]);
//            }
        }
        dd($tokensToProcess);
        $scope = array_values($scope);

        foreach ($scope as $key => $token) {
            if ($token['type'] !== 'T_DOUBLE_ARROW') {
                continue;
            }

            $arrayKeyTokenFound = $scope[$key - 1];
            $keyFound = $arrayKeyTokenFound['content'];
            if (in_array($keyFound, $this->keysFound)) {
                $phpcsFile->addError("Array contains a duplicate key: {$keyFound}.", $stackPtr);
                continue;
            }
            $this->keysFound[] = $keyFound;
        }
    }

    private function handleToken($token)
    {
        $opener = $token['bracket_opener'];
        $closer = $token['bracket_closer'];
//        dd($opener, $closer);
        
    }
}
