<?php declare(strict_types = 1);

/**
 * @return mixed
 */
function foo()
{
}

/**
 * @return stdClass|mixed
 */
function bar()
{
}

/**
 * @return null|mixed
 */
function containsNull()
{
}

/**
 * @return null|mixed
 */
function orderIsIrrelevant()
{
}

class someClass
{
    /**
     * @return mixed
     */
    public function foo()
    {
    }

    /**
     * @return stdClass|mixed
     */
    public function bar()
    {
    }

    /**
     * @return mixed|null
     */
    public function containsNull()
    {
    }

    /**
     * @return null|mixed
     */
    public function orderIsIrrelevant()
    {
    }
}
