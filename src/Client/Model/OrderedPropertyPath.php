<?php

namespace AmberSdk\Client\Model;


class OrderedPropertyPath extends PropertyPath
{
    /**
     * @var string
     */
    public $order;

    /**
     * @param string $property
     * @param string $order
     */
    function __construct($property, $order)
    {
        $this->order = $order;
        parent::__construct($property);
    }
}