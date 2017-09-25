<?php

namespace AmberSdk\Client\Model;


class ExecutionQuery
{
    /**
     * @var string
     */
    public $customObjectCode;

    /**
     * @var PropertyPath[]
     */
    public $select;

    /**
     * @var ExpressionElement[]
     */
    public $where;

    /**
     * @var OrderedPropertyPath[]
     */
    public $orderBy;

    /**
     * @var int
     */
    public $offset;
    /**
     * @var int
     */
    public $pageSize;


}