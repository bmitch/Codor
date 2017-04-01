<?php declare(strict_types = 1);

namespace Codor\Tests\Wrappers;

use PHP_CodeSniffer_File;

class Results
{
    /**
     * This is the class that we're wrapping up.
     * @var PHP_CodeSniffer_File
     */
    protected $wrappedClass;

    /**
     * Class constructor.
     * @param PHP_CodeSniffer_File $wrappedClass Class we're wrapping up.
     */
    public function __construct(PHP_CodeSniffer_File $wrappedClass)
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
        foreach ($errors as $error) {
            $allErrorMessages[] = reset($error)[0]['message'];
        }

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
