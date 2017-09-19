<?php

namespace AmberSdk\Client\Model;


class ExpressionElement
{
    /**
     * @var Brackets
     */
    public $brackets;
    /**
     * @var ConstantElement
     */
    public $constant;
    /**
     * @var FunctionElement
     */
    public $function;
    /**
     * @var Operator
     */
    public $operator;
    /**
     * @var PropertyPath
     */
    public $propertyPath;

    /**
     * @param Brackets $brackets
     * @param ConstantElement $constant
     * @param FunctionElement $function
     * @param Operator $operator
     * @param PropertyPath $propertyPath
     */
    function __construct($brackets, $constant, $function, $operator, $propertyPath)
    {
        $this->brackets = $brackets;
        $this->constant = $constant;
        $this->function = $function;
        $this->operator = $operator;
        $this->propertyPath = $propertyPath;
    }

}