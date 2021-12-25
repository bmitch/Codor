<?php
class Foo
{
    public function filter(array $items): array
    {
        return array_filter($items, function ($item) {
            return $item !== null;
        });
    }
}