<?php

namespace EloquentSearcher;

use Carbon\Carbon;

class Searcher
{
    const EQUALS = 'equals';
    const CONTAINS = 'contains';
    const STARTSWITH = 'startswith';
    const ENDSWITH = 'endswith';
    const GT = 'gt';
    const GTE = 'gte';
    const LT = 'lt';
    const LTE = 'lte';
    const RANGE = 'range';
    const DATE_RANGE = 'dateRange';
    const DATETIME_RANGE = 'datetimeRange';
    const IN = 'in';
    const IS_NULL = 'isNull';
    const IS_NOT_NULL = 'isNotNull';
    const IS_TRUE = 'isTrue';
    const IS_NOT_TRUE = 'isNotTrue';
    const IS_FALSE = 'isFalse';
    const IS_NOT_FALSE = 'isNotFalse';

    const AND = 'and';
    const OR = 'or';

    protected $searchFields = [];
    protected $keywordFields = [];
    protected $keywordFieldName = 'keyword';
    protected $keywordSearchTerms = Searcher::AND;

    public function build($query, $conditions)
    {
        // Build condition.
        foreach ($this->getSearchFields() as $field => $func) {
            $value = array_get($conditions, $field);
            if (is_null($value)) {
                continue;
            }
            $query = $this->resolveFunction($query, $field, $func, $value);
        }

        // Build keyword condition.
        $keyword = array_get($conditions, $this->keywordFieldName);
        if ($keyword) {
            $query = $this->keyword($query, $keyword);
        }

        return $query;
    }

    protected function getSearchFields()
    {
        return $this->searchFields;
    }

    protected function getKeywordFields()
    {
        return $this->keywordFields;
    }

    protected function resolveFunction($query, $field, $func, $value)
    {
        if (! is_array($field)) {
            $field = explode('.', $field);
        }

        if (count($field) === 1) {
            return $this->{$func}($query, $field[0], $value);
        } else {
            $relation = array_shift($field);
            return $query->whereHas($relation, function ($query) use ($field, $func, $value) {
                return $this->resolveFunction($query, $field, $func, $value);
            });
        }
    }

    protected function keyword($query, $value)
    {
        $values = preg_split('/\s+/', $value);
        $fields = $this->getKeywordFields();

        $query->where(function ($query) use ($fields, $values) {
            $where = $this->keywordSearchTerms === static::AND ? 'where' : 'orWhere';
            foreach ($values as $value) {
                $query->{$where}(function ($query) use ($fields, $value) {
                    foreach ($fields as $field => $func) {
                        $query->orWhere(function ($query) use ($field, $func, $value) {
                            return $this->resolveFunction($query, $field, $func, $value);
                        });
                    }
                });
            }
        });

        return $query;
    }

    protected function equals($query, $field, $value)
    {
        return $query->where($field, $value);
    }

    protected function contains($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%{$value}%");
    }

    protected function startswith($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "{$value}%");
    }

    protected function endswith($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%{$value}");
    }

    protected function gt($query, $field, $value)
    {
        return $query->where($field, '>', $value);
    }

    protected function gte($query, $field, $value)
    {
        return $query->where($field, '>=', $value);
    }

    protected function lt($query, $field, $value)
    {
        return $query->where($field, '<', $value);
    }

    protected function lte($query, $field, $value)
    {
        return $query->where($field, '<=', $value);
    }

    protected function range($query, $field, $value)
    {
        $query = $this->gte($query, $field, current($value));
        if (count($value) > 1) {
            $query = $this->lte($query, $field, next($value));
        }
        return $query;
    }

    protected function dateRange($query, $field, $value)
    {
        $from = (new Carbon(current($value)))->startOfDay();
        $query = $this->gte($query, $field, $from);
        if (count($value) > 1) {
            $until = (new Carbon(next($value)))->startOfDay()->addDay();
            $query = $this->lt($query, $field, $until);
        }
        return $query;
    }

    protected function datetimeRange($query, $field, $value)
    {
        $query = $this->gte($query, $field, new Carbon(current($value)));
        if (count($value) > 1) {
            $until = new Carbon(next($value));
            $query = $this->lt($query, $field, $until);
        }
        return $query;
    }

    protected function in($query, $field, $value)
    {
        return $query->whereIn($field, $value);
    }

    protected function isNull($query, $field, $value)
    {
        if ($value) {
            return $query->whereNull($field);
        }
        return $query->whereNotNull($field);
    }

    protected function isNotNull($query, $field, $value)
    {
        if ($value) {
            return $query->whereNotNull($field);
        }
        return $query->whereNull($field);
    }

    protected function isTrue($query, $field, $value)
    {
        return $query->where($field, (bool)$value);
    }

    protected function isNotTrue($query, $field, $value)
    {
        return $query->where($field, !$value);
    }

    protected function isFalse($query, $field, $value)
    {
        return $query->where($field, !$value);
    }

    protected function isNotFalse($query, $field, $value)
    {
        return $query->where($field, (bool)$value);
    }
}
