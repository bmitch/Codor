<?php declare(strict_types = 1);

interface someInterface
{
    /**
     * @return null
     */
	public function foo();
    /**
     * @return bool
     */
    public function bar();

    /**
     * @return array
     */
    public function baz();

    /**
     * @return null
     */
    public function qux();

    /**
     * @return string|array
     */
	public function quux();

    /**
     * @return mixed
     */
	public function errorOne();

    /**
     * @return mixed|null
     */
	public function errorTwo();
}
