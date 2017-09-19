<?php

namespace AmberSdk\Client\Model;


class Operator
{
    /**
     * @var string
     */
    public $operatorCode;

    /**
     * @param string $operatorCode
     */
    function __construct($operatorCode)
    {
        $this->operatorCode = $operatorCode;
    }
}