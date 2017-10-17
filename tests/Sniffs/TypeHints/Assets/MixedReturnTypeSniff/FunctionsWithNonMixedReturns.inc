<?php declare(strict_types = 1);

/**
 * @return void
 */
function foo()
{
}

/**
 * @return bool
 */
function bar()
{
	return true;
}

/**
 * @return array
 */
function baz()
{
	return [];
}

/**
 * @return null
 */
function qux()
{
	return null;
}

/**
 * @return string|array
 */
function quux()
{
	return '';
}

class someClass
{
    /**
     * @return void
     */
    public function foo()
    {

    }

    /**
     * @return bool
     */
    public function bar()
    {
        return true;
    }

    /**
     * @return array
     */
    public function baz()
    {
        return [];
    }

    /**
     * @return null
     */
    public function qux()
    {
        return null;
    }

    /**
     * @return string|array
     */
    public function quux()
    {
        return '';
    }
}
