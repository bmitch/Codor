<?php


class NewInConstructor
{
    private MyClass $myClass;

    public function __construct()
    {
        $this->myClass = new MyClass();
    }
}
