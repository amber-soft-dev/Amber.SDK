<?php

namespace AmberSdk\Client\Model;


class FunctionElement
{
    /**
     * @var string
     */
    public $functionCode;

    /**
     * @var ExpressionElement[]
     */
    public $arguments;

    /**
     * @param string $functionCode
     * @param array $arguments
     */
    function __construct($functionCode, array $arguments)
    {
        $this->functionCode = $functionCode;
        $this->arguments = $arguments;
    }
}