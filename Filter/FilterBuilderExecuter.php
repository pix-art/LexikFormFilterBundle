<?php

namespace Lexik\Bundle\FormFilterBundle\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class FilterBuilderExecuter implements FilterBuilderExecuterInterface
{
    /**
     * @var QueryInterface
     */
    protected $filterQuery;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var array
     */
    protected $parts;

    /**
     * Construct.
     *
     * @param QueryInterface $filterBuilder
     * @param string         $alias
     * @param array          $parts
     */
    public function __construct(QueryInterface $filterQuery, $alias, array & $parts = array())
    {
        $this->filterQuery = $filterQuery;
        $this->alias       = $alias;
        $this->parts       = & $parts;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * {@inheritdoc}
     */
    public function addOnce($join, $alias, \Closure $callback = null)
    {
        if (isset($this->parts[$join])) {
            return null;
        }

        $this->parts[$join] = $alias;

        if (!$callback instanceof \Closure) {
            return;
        }

        return $callback($this->filterQuery->getQueryBuilder(), $this->alias, $alias, $this->filterQuery->getExpr());
    }
}
