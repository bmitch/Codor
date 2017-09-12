<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class GentleClassLengthSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The maximum number of logical lines a class
     * should have.
     * @var integer
     */
    public $maxLength = 100;

    /**
     * Holds the lines that cannot possibly be a logical line of code.
     * @var array
     */
    private $nonLogicalLines = [];

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
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $openParenthesis = $tokens[$token['scope_opener']];
        $closedParenthesis = $tokens[$token['scope_closer']];

        foreach ($tokens as $token) {
            if ($token['line'] <= $openParenthesis['line'] || $token['line'] >= $closedParenthesis['line']) {
                continue;
            }
            $this->handleToken($token);
        }

        $length = $closedParenthesis['line'] - $openParenthesis['line'];

        if ($this->exceedsLimit($length)) {
            $phpcsFile->addError(
                "Class has " . $this->numberOfLogicalLines($length) . " logical lines of code. Must be {$this->maxLength} lines or fewer.",
                $stackPtr
            );
        }
    }

    /**
     * Handle a specific token.
     * @param array $token Token data.
     * @return void
     */
    private function handleToken($token)
    {
        if ($this->cannotBeLogicalLine($token)) {
            $this->nonLogicalLines[] = $token['line'];
        }
    }

    /**
     * Checks to see if the provided token cannot possibly
     * be a logical line of code.
     * @param array $token Token data.
     * @return boolean
     */
    private function cannotBeLogicalLine($token): bool
    {
        return  (in_array($token['type'], [
            'T_OPEN_TAG',
            'T_DECLARE',
            'T_CLASS',
            'T_PUBLIC',
            'T_PRIVATE',
            'T_PROTECTED',
            'T_FUNCTION',
            'T_DOC_COMMENT_OPEN_TAG',
            'T_DOC_COMMENT_WHITESPACE',
            'T_DOC_COMMENT_STAR',
            'T_DOC_COMMENT_STRING',
            'T_DOC_COMMENT_CLOSE_TAG',
            'T_COMMENT',
            'T_CLOSE_CURLY_BRACKET',
        ]));
    }

    /**
     * Checks to see if the number of logical lines of code
     * exceeds the maximum specified.
     * @param int $classLength Total lines of the class.
     * @return boolean
     */
    private function exceedsLimit(int $classLength): bool
    {
        return ($this->numberOfLogicalLines($classLength) > $this->maxLength);
    }

    /**
     * Gets the number of non logical lines of code.
     * @return integer
     */
    private function numberOfNonLogicalLines(): int
    {
        return count(array_unique($this->nonLogicalLines));
    }

    /**
     * Gets the number of logical lines of code.
     * @param int $classLength Total lines of the class.
     * @return mixed
     */
    private function numberOfLogicalLines(int $classLength)
    {
        return $classLength - $this->numberOfNonLogicalLines();
    }
}
