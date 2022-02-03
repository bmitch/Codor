<?php declare(strict_types = 1);

namespace Codor\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff as PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer\Files\File as PHP_CodeSniffer_File;

class NewInstanceSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
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
        $functionName = $tokens[$stackPtr + 2]['content'];

        $scopes = $this->getBracketsIndex($tokens, $stackPtr);
        if (true === empty($scopes['open']) || true === empty($scopes['close'])) {
            return;
        }

        for ($index=$scopes['open']; $index <= $scopes['close']; $index++) {
            if ($tokens[$index]['type'] === 'T_NEW') {
                $phpcsFile->addWarning($this->getWarningMessage($functionName), $tokens[$index]['column'], __CLASS__);
            }
        }
    }

    private function getBracketsIndex(array $tokens, int $stackPtr) : array
    {
        $token = $tokens[$stackPtr];
        $open = $token['scope_opener'] ?? null;
        $close = $token['scope_closer'] ?? null;

        if (true === empty($open)) {
            return $this->searchBrackets($tokens, $stackPtr);
        }

        return [
            'open' => $open,
            'close' => $close
        ];
    }

    private function searchBrackets(array $tokens, int $stackPtr) : array
    {
        $open = $close = null;
        for ($i=$stackPtr; $i < count($tokens); $i++) {
            if ($tokens[$i]['type'] === 'T_OPEN_CURLY_BRACKET') {
                $open = $i;
            }
            if ($tokens[$i]['type'] === 'T_CLOSE_CURLY_BRACKET') {
                $close = $i;
            }
        }

        return [
            'open' => $open,
            'close' => $close
        ];
    }

    /**
     * Gets the warning message for this sniff.
     * @return string
     */
    protected function getWarningMessage(string $functionName): string
    {
        return sprintf('Function %s use new keyword - consider to use DI.', $functionName);
    }
}
