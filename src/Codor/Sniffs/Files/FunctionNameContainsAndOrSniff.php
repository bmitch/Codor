<?php

namespace Codor\Sniffs\Files;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class FunctionNameContainsAndOrSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The forbidden strings this sniff looks for.
     * @var array
     */
    protected $keywords = ['And', '_and', 'Or', '_or'];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register()
    {
        return [T_FUNCTION];
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
        $functionNameToken = $tokens[$stackPtr + 2];
        $functionName = $functionNameToken['content'];

        if (! $this->containsKeywords($functionName)) {
            return;
        }

        if (! $this->ensuingDelimiter($functionName)) {
            return;
        }

        $phpcsFile->addError($this->getErrorMessage(), $stackPtr);
    }

    /**
     * Determines if the provided $string contains any of the
     * strings in the $this->keywords property.
     * @param  string $string The string to check.
     * @return boolean
     */
    protected function containsKeywords($string)
    {
        $contains = false;
        foreach ($this->keywords as $keyword) {
            $this->contains($keyword, $string) ? $contains = true : null;
        }

        return $contains;
    }

    /**
     * Determines if the matched keyword has an ensuing
     * CamelCased or snake_cased delimiter.
     * @param string $string The string to check.
     * @return boolean
     */
    protected function ensuingDelimiter($string)
    {
        foreach ($this->keywords as $keyword) {
            if (! $this->contains($keyword, $string)) {
                continue;
            }

            $remaining = substr(strstr($string, $keyword), strlen($keyword));
            $leadChar = substr($remaining, 0, 1);

            // Base case
            if (ctype_upper($leadChar) || $leadChar == '_') {
                return true;
            }

            return $this->ensuingDelimiter($remaining);
        }

        return false;
    }

    /**
     * Checks if the $haystack contains the $needle.
     * @param  string $needle   Needle string.
     * @param  string $haystack Haystack string.
     * @return boolean
     */
    protected function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Gets the error message for this sniff.
     * @return string
     */
    protected function getErrorMessage()
    {
        return "Your function contains 'and' or 'or' which indicates it might be doing more than one thing.";
    }
}
