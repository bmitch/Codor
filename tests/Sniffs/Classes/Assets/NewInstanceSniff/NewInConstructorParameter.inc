<?php

class Foo {
    public function __construct(
        private $bar = new stdClass()
    ) {}
    
    public function getBar() {
        return $this->bar;
    }
}