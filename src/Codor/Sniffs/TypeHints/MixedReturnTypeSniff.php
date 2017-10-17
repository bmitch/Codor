<?php declare(strict_types = 1);

namespace Codor\Sniffs\TypeHints;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Tokens;

class MixedReturnTypeSniff implements PHP_CodeSniffer_Sniff
{
    private const RETURN_TAG_NAME = '@return';
    private const MIXED_TYPE = 'mixed';

    /**
     * Returns the token types that this sniff is interested in.
     * @return array
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $commentEnd = $this->findCommentEnd($phpcsFile, $stackPtr, $tokens);

        $commentStart = $tokens[$commentEnd]['comment_opener'];

        $this->processReturn($phpcsFile, $commentStart);
    }

    /**
     * Process the return comment of this function comment.
     *
     * @param PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     *                                           in the stack passed in $tokens.
     * @param int                  $commentStart The position in the stack where the comment started.
     */
    protected function processReturn(PHP_CodeSniffer_File $phpcsFile, $commentStart): void
    {
        $tokens = $phpcsFile->getTokens();

        $return = $this->findReturnTag($tokens, $commentStart);

        if ($return === null) {
            return;
        }

        $returnType = $this->parseTagForReturnType($tokens, $return);
        if ($returnType === null) {
            return;
        }

        // Check return type (can be multiple, separated by '|').
        $typeNames = explode('|', $returnType);

        foreach ($typeNames as $typeName) {
            if ($typeName === self::MIXED_TYPE) {
                $phpcsFile->addError('Function return type contains mixed', $commentStart);
            }
        }
    }

    /**
     * Finds the (first) return tag, if any, in the comment
     *
     * @param array $tokens Token stack
     * @param int   $commentStart Pointer to start of comment
     *
     * @return int|null
     */
    private function findReturnTag(array $tokens, int $commentStart): ?int
    {
        return array_reduce($tokens[$commentStart]['comment_tags'], function ($carry, $tag) use ($tokens) {
            return $carry || ($tokens[$tag]['content'] === self::RETURN_TAG_NAME) ? $tag : null;
        }, null);
    }

    /**
     * @param array $tokens         Token stack
     * @param int   $returnPosition Pointer to return tag
     *
     * @return string|null
     */
    private function parseTagForReturnType(array $tokens, int $returnPosition): ?string
    {
        $content = $tokens[$returnPosition + 2]['content'];
        // Support both a return type and a description.
        preg_match('`^((?:\|?(?:array\([^\)]*\)|[\\\\a-z0-9\[\]]+))*)( .*)?`i', $content, $returnParts);

        return $returnParts[1] ?? null;
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     * @param array                $tokens    Token stack
     *
     * @return bool|int
     */
    private function findCommentEnd(PHP_CodeSniffer_File $phpcsFile, $stackPtr, array $tokens)
    {
        $find = PHP_CodeSniffer_Tokens::$methodPrefixes + T_WHITESPACE;

        $commentEnd = $phpcsFile->findPrevious($find, $stackPtr - 1, null, true);
        if ($tokens[$commentEnd]['code'] !== T_COMMENT) {
            return $commentEnd;
        }

        // Inline comments might just be closing comments for
        // control structures or functions instead of function comments
        // using the wrong comment type. If there is other code on the line,
        // assume they relate to that code.
        $prev = $phpcsFile->findPrevious($find, $commentEnd - 1, null, true);
        if ($prev !== false && $tokens[$prev]['line'] === $tokens[$commentEnd]['line']) {
            $commentEnd = $prev;
        }

        return $commentEnd;
    }
}
