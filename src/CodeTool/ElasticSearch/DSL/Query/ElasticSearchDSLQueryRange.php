<?php

declare(strict_types = 1);

namespace CodeTool\ElasticSearch\DSL\Query;

use CodeTool\ElasticSearch\DSL\ElasticSearchDSLQueryInterface;

/**
 * RangeQuery matches documents with fields that have terms within a certain range.
 *
 * For details, @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
 */
class ElasticSearchDSLQueryRange implements ElasticSearchDSLQueryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $gt;

    /**
     * @var string
     */
    private $gte;

    /**
     * @var string
     */
    private $lt;

    /**
     * @var string
     */
    private $lte;

    /**
     * @var string
     */
    private $timeZone = '';

    /**
     * @var float
     */
    private $boost;

    /**
     * @var string
     */
    private $queryName = '';

    /**
     * @var string
     */
    private $format = '';

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var bool
     */
    private $includeLower = true;

    /**
     * @var bool
     */
    private $includeUpper = true;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $from
     *
     * @return $this
     *
     * @deprecated Deprecated in favour of {@see gt}, {@see gte} methods
     */
    public function from(string $from)
    {
        $this->from = $from;

        return $this;
    }

    public function gt($from)
    {
        $this->gt = $from;

        return $this;
    }

    public function gte($from)
    {
        $this->gte = $from;

        return $this;
    }

    /**
     * @param string $to
     *
     * @return $this
     *
     * @deprecated Deprecated in favour of {@see lt}, {@see lte} methods
     */
    public function to(string $to)
    {
        $this->to = $to;

        return $this;
    }

    public function lt($to)
    {
        $this->lt = $to;

        return $this;
    }

    public function lte($to)
    {
        $this->lte = $to;

        return $this;
    }

    /**
     * Note: Works only in pair with usage of `from()` and `to()` methods!
     *
     * @param bool $includeLower
     *
     * @return $this
     *
     * @deprecated Deprecated in favour of {@see gt}, {@see gte}, {@see lt}, {@see lte} methods
     */
    public function includeLower(bool $includeLower)
    {
        $this->includeLower = $includeLower;

        return $this;
    }

    /**
     * Note: Works only with usage of `from()` and `to()` methods!
     *
     * @param bool $includeUpper
     *
     * @return $this
     *
     * @deprecated Deprecated in favour of {@see gt}, {@see gte}, {@see lt}, {@see lte} methods
     */
    public function includeUpper(bool $includeUpper)
    {
        $this->includeUpper = $includeUpper;

        return $this;
    }

    public function boost(float $boost)
    {
        $this->boost = $boost;

        return $this;
    }

    public function queryName(string $queryName)
    {
        $this->queryName = $queryName;

        return $this;
    }

    public function format(string $format)
    {
        $this->format = $format;

        return $this;
    }

    public function jsonSerialize()
    {
        $params = [];
        if (null !== $this->gt) {
            $params['gt'] = $this->gt;
        }

        if (null !== $this->gte) {
            $params['gte'] = $this->gte;
        }

        if (null !== $this->lt) {
            $params['lt'] = $this->lt;
        }

        if (null !== $this->lte) {
            $params['lte'] = $this->lte;
        }

        if (null !== $this->from) {
            $params['from'] = $this->from;
            $params['include_lower'] = $this->includeLower;
        }

        if (null !== $this->to) {
            $params['to'] = $this->to;
            $params['include_upper'] = $this->includeUpper;
        }

        if ('' !== $this->timeZone) {
            $params['tile_zone'] = $this->timeZone;
        }

        if ('' !== $this->format) {
            $params['format'] = $this->format;
        }

        if (null !== $this->boost) {
            $params['boost'] = $this->boost;
        }

        $query = [$this->name => $params];
        if ('' !== $this->queryName) {
            $query['_name'] = $this->queryName;
        }

        return ['range' => $query];
    }
}
