<?php declare(strict_types = 1);

namespace Codor\Sniffs\ControlStructures;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class NoControlStructuresSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The forbidden strings this sniff looks for.
     * @var array
     */
    public $keywords = [];

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_IF, T_ELSE, T_SWITCH, T_WHILE, T_FOR, T_FOREACH];
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
        if ($this->matchesFilenamesFilter($phpcsFile->getFilename())) {
            $phpcsFile->addError('Do not use control structures or loops in this file.', $stackPtr);
        }
    }

    protected function matchesFilenamesFilter($filename)
    {
        if ($this->keywords == []) {
            return false;
        }

        $filename = explode("/", $filename);
        $filename = end($filename);

        foreach ($this->keywords as $keyword) {
            if ($this->contains($filename, $keyword)) {
                return true;
            }
        }

        return false;
    }

    protected function contains($haystack, $needle)
    {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }

        return false;
    }
}
