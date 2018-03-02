<?php declare(strict_types = 1);

namespace Codor\Tests\Wrappers;

use PHP_CodeSniffer\Files\File;

class Results
{
    /**
     * This is the class that we're wrapping up.
     * @var File
     */
    protected $wrappedClass;

    /**
     * Class constructor.
     * @param File $wrappedClass Class we're wrapping up.
     */
    public function __construct(File $wrappedClass)
    {
        $this->wrappedClass = $wrappedClass;
    }

    /**
     * Gets all the error messages produced by the sniff.
     * @return array
     */
    public function getAllErrorMessages(): array
    {

        $allErrorMessages = [];
        $errors = $this->wrappedClass->getErrors();
        array_walk_recursive($errors, function (&$item, $key) use (&$allErrorMessages) {
            if ($key == 'message') {
                $allErrorMessages[] = $item;
            }
        });
        return $allErrorMessages;
    }

    /**
     * Gets all the warning messages produced by the sniff.
     * @return array
     */
    public function getAllWarningMessages(): array
    {
        $getAllWarningMessages = [];
        $warnings = $this->wrappedClass->getWarnings();
        foreach ($warnings as $warning) {
            $getAllWarningMessages[] = reset($warning)[0]['message'];
        }

        return $getAllWarningMessages;
    }

    /**
     * Gets the number of errors produced by the sniff.
     * @return integer
     */
    public function getErrorCount(): int
    {
        return $this->wrappedClass->getErrorCount();
    }

    /**
     * Gets the number of warnings produced by the sniff.
     * @return integer
     */
    public function getWarningCount(): int
    {
        return $this->wrappedClass->getWarningCount();
    }
}
