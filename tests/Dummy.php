<?php

namespace EloquentSearcher\Test;

use Illuminate\Database\Eloquent\Model;

use EloquentSearcher\SearchableTrait;

class Dummy extends Model
{
    use SearchableTrait;

    protected $searcher = DummySearcher::class;
    protected $table = 'dummies';
    public $timestamps = false;
    protected $dates = [
        'date_range',
        'datetime_range',
    ];

    protected $fillable = [
        'text_equals',
        'text_contains',
        'text_startswith',
        'text_endswith',
        'integer_gt',
        'integer_gte',
        'integer_lt',
        'integer_lte',
        'integer_range',
        'integer_in',
        'integer_is_null',
        'integer_is_not_null',
        'boolean_is_true',
        'boolean_is_not_true',
        'boolean_is_false',
        'boolean_is_not_false',
        'date_range',
        'datetime_range',
        'text_custom_function',
    ];

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }
}
