<?php

namespace AmberSdk\Client\Model;


class ConstantElement
{
    /**
     * @var string
     */
    public $dataTypeCode;

    /**
     * @var string
     */
    public $value;

    /**
     * @param string $dataTypeCode
     * @param string $value
     */
    function __construct($dataTypeCode, $value)
    {
        $this->dataTypeCode = $dataTypeCode;
        $this->value = $value;
    }
}