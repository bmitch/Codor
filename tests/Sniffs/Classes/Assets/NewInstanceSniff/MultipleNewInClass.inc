<?php

class MultipleNewInClass
{
    private MyClass $myClass;

    public function __construct()
    {
        $this->myClass = new MyClass();
    }

    public function newInstance() : MyClass
    {
        return new MyClass();
    }
}
