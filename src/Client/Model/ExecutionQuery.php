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

    /**
     * @param string $customObjectCode
     * @param array $select
     * @param array $where
     * @param array $orderBy
     * @param int $offset
     * @param int $pageSize
     */
    function __construct($customObjectCode, array $select, array $where, array $orderBy, $offset, $pageSize)
    {
        $this->customObjectCode = $customObjectCode;
        $this->select = $select;
        $this->where = $where;
        $this->orderBy = $orderBy;
        $this->offset = $offset;
        $this->pageSize = $pageSize;
    }

}