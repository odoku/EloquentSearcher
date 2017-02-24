<?php

namespace EloquentSearcher\Test;

use EloquentSearcher\Searcher;

class DummySearcher extends Searcher
{
    protected $searchFields = [
        'text_equals' => Searcher::EQUALS,
        'text_contains' => Searcher::CONTAINS,
        'text_startswith' => Searcher::STARTSWITH,
        'text_endswith' => Searcher::ENDSWITH,
        'integer_gt' => Searcher::GT,
        'integer_gte' => Searcher::GTE,
        'integer_lt' => Searcher::LT,
        'integer_lte' => Searcher::LTE,
        'integer_range' => Searcher::RANGE,
        'integer_in' => Searcher::IN,
        'integer_is_null' => Searcher::IS_NULL,
        'integer_is_not_null' => Searcher::IS_NOT_NULL,
        'boolean_is_true' => Searcher::IS_TRUE,
        'boolean_is_not_true' => Searcher::IS_NOT_TRUE,
        'boolean_is_false' => Searcher::IS_FALSE,
        'boolean_is_not_false' => Searcher::IS_NOT_FALSE,
        'date_range' => Searcher::DATE_RANGE,
        'datetime_range' => Searcher::DATETIME_RANGE,
        'text_custom_function' => 'customFunction',

        'parent.text_equals' => Searcher::EQUALS,
        'parent.text_contains' => Searcher::CONTAINS,
        'parent.text_startswith' => Searcher::STARTSWITH,
        'parent.text_endswith' => Searcher::ENDSWITH,
        'parent.integer_gt' => Searcher::GT,
        'parent.integer_gte' => Searcher::GTE,
        'parent.integer_lt' => Searcher::LT,
        'parent.integer_lte' => Searcher::LTE,
        'parent.integer_range' => Searcher::RANGE,
        'parent.integer_in' => Searcher::IN,
        'parent.integer_is_null' => Searcher::IS_NULL,
        'parent.integer_is_not_null' => Searcher::IS_NOT_NULL,
        'parent.boolean_is_true' => Searcher::IS_TRUE,
        'parent.boolean_is_not_true' => Searcher::IS_NOT_TRUE,
        'parent.boolean_is_false' => Searcher::IS_FALSE,
        'parent.boolean_is_not_false' => Searcher::IS_NOT_FALSE,
        'parent.date_range' => Searcher::DATE_RANGE,
        'parent.datetime_range' => Searcher::DATETIME_RANGE,
        'parent.text_custom_function' => 'customFunction',
    ];

    protected $keywordFields = [
        'text_equals' => Searcher::EQUALS,
        'text_contains' => Searcher::CONTAINS,
        'text_startswith' => Searcher::STARTSWITH,
        'text_endswith' => Searcher::ENDSWITH,
        'text_custom_function' => 'customFunction',
    ];

    protected function customFunction($query, $field, $value)
    {
        return $query->where($field, $value);
    }
}
