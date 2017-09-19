<?php

namespace AmberSdk\Client\Model;


class PropertyPath
{
    /**
     * @var string
     */
    public $property;

    /**
     * @param string $property
     */
    function __construct($property)
    {
        $this->property = $property;
    }
}