<?php

namespace AmberSdk\Client\Model;


class Brackets
{
    /**
     * @var ExpressionElement[]
     */
    public $items;

    /**
     * @param array $items
     */
    function __construct(array $items)
    {
        $this->items = $items;
    }
}