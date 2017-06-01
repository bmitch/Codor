<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class PropertyDeclarationSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The decalred member variables in the class.
     * @var array
     */
    protected $memberVars = [];

    /**
     * The referenced member variables in the class.
     * @var array
     */
    protected $referencedMemberVars = [];

    /**
     * Visibility Tokens.
     * @var array
     */
    protected $visibilityTokens = ['T_PRIVATE', 'T_PUBLIC', 'T_PROTECTED'];

    /**
     * Holds the value if the class is extended or not.
     * @var boolean
     */
    protected $isExtendedClass = false;

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
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     * @return void
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->memberVars = [];
        $this->referencedMemberVars = [];
        $tokens = $phpcsFile->getTokens();
        foreach ($tokens as $index => $token) {
            $this->handleToken($tokens, $index);
        }

        $undeclaredMemberVars = array_diff($this->referencedMemberVars, $this->memberVars);

        foreach ($undeclaredMemberVars as $undeclaredVariable) {
            $this->handleError($undeclaredVariable, $phpcsFile, $stackPtr);
        }
    }

    /**
     * Handle the incoming token.
     * @param  array   $tokens List of tokens.
     * @param  integer $index  Current token index.
     * @return void
     */
    protected function handleToken($tokens, $index)
    {
        $token = $tokens[$index];

        if ($token['type'] === 'T_EXTENDS') {
            $this->isExtendedClass = true;
            return;
        }

        if ($this->isVisibilityToken($token)) {
            $this->handleVisibilityToken($tokens, $index);
            return;
        }


        if ($token['type'] === 'T_OBJECT_OPERATOR') {
            $this->handleObjectOperatorToken($tokens, $index);
            return;
        }
    }

    /**
     * Determines if the provided token is a visiblity token.
     * @param  array $token Token data.
     * @return boolean
     */
    protected function isVisibilityToken($token): bool
    {
        return in_array($token['type'], $this->visibilityTokens);
    }

    /**
     * Handles the logic for a visiblity type token.
     * @param  array   $tokens List of tokens.
     * @param  integer $index  Current token index.
     * @return void
     */
    protected function handleVisibilityToken($tokens, $index)
    {
        $possibleVariable = $tokens[$index + 2];
        if ($possibleVariable['type'] !== 'T_VARIABLE') {
            return;
        }
        $this->memberVars[] = str_replace('$', '', $possibleVariable['content']);
    }

    /**
     * Handles the logic for an object operator token.
     * @param  array   $tokens List of tokens.
     * @param  integer $index  Current token index.
     * @return void
     */
    protected function handleObjectOperatorToken($tokens, $index)
    {
        $previousToken = $tokens[$index-1];
        $nextToken = $tokens[$index+1];
        $tokenAfterNext = $tokens[$index+2];

        if ($previousToken['content'] !== '$this') {
            return;
        }

        if (($tokenAfterNext['type'] !== 'T_WHITESPACE') && ($tokenAfterNext['type'] !== 'T_EQUAL')) {
            return;
        }

        $this->referencedMemberVars[] = $nextToken['content'];
    }

    /**
     * If the class is extended from another class then a warning is produced.
     * Otherwise an error is produced.
     * @param  string               $undeclaredVariable Name of the undeclared member variable.
     * @param  PHP_CodeSniffer_File $phpcsFile          PHP Code Sniffer File.
     * @param  integer              $index              Index of where the undeclared variable was found in the file.
     * @return void
     */
    protected function handleError($undeclaredVariable, $phpcsFile, $index)
    {
        if ($this->isExtendedClass) {
            $phpcsFile->addWarning("Class contains undeclared property {$undeclaredVariable}.", $index);
            return;
        }
        $phpcsFile->addError("Class contains undeclared property {$undeclaredVariable}.", $index);
    }
}
