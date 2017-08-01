<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class ExtendsSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * The file where the token was found.
     * @var PHP_CodeSniffer_File
     */
    private $phpcsFile;

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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        foreach ($phpcsFile->getTokens() as $token) {
            $this->handleToken($token);
        }
    }

    /**
     * Handle the incoming token.
     * @param  array $token Token data.
     * @return void
     */
    protected function handleToken($token)
    {
        if ($token['type'] !== 'T_EXTENDS') {
            return;
        }
        $warning = "Class extends another class - consider composition over inheritance.";
        $this->phpcsFile->addWarning($warning, $token['line']);
    }
}
