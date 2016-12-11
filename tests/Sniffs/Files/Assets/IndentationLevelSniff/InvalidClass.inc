<?php

class Foo
{

    protected $baz;

    public function foo()
    {
        return true;
    }

    public function bar()
    {
        $one = 1;
        $two = 2;
        $three = 3;
        return true;
    }

    public function baz()
    {
        if (true) {
            return true;
        }

        return false;
    }

    public function tooMuchIndentation()
    {
        if (true) {
            if (true) {
                return "Uh oh";
            }
        }

        return false;
    }
}