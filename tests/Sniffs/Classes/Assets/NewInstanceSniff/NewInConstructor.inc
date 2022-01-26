<?php


class NewInConstructor
{
    protected $myClass;

    public function __construct(MyClass $myClass)
    {
        $this->myClass = new MyClass();
    }
}
