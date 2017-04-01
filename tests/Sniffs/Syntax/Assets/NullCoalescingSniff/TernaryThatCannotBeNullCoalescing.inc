<?php declare(strict_types = 1);

$foo = ($_GET['foo'] == 1) ? $_GET['foo'] : 'bar';

if (isset($foo)) {
    $bar = $foo;
}