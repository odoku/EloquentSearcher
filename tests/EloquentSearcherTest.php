<?php

namespace EloquentSearcher\Test;

use Carbon\Carbon;

class EloquentSearcherTest extends TestCase
{
    protected function isNotDefaultQuery($query)
    {
        return $query->toSql() !== 'select * from "dummies"';
    }

    /** @test */
    public function testEquals()
    {
        $conditions = ['text_equals' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_equals' => 'equals'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_equals' => 'not equals'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testContains()
    {
        $conditions = ['text_contains' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_contains' => 'contains'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_contains' => 'not contains'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testStartswith()
    {
        $conditions = ['text_startswith' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_startswith' => 'startswith'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_startswith' => 'not startswith'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testEndswith()
    {
        $conditions = ['text_endswith' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_endswith' => 'endswith'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_endswith' => 'not endswith'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testGreaterThan()
    {
        $conditions = ['integer_gt' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_gt' => 4];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_gt' => 5];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testGreaterThanEquals()
    {
        $conditions = ['integer_gte' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_gte' => 5];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_gte' => 6];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testLowerThan()
    {
        $conditions = ['integer_lt' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_lt' => 6];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_lt' => 5];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testLowerThanEquals()
    {
        $conditions = ['integer_lte' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_lte' => 5];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_lte' => 4];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testRange()
    {
        $conditions = ['integer_range' => []];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [null, null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [4]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [4, null]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [null, 6]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [4, 6]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [5, 6]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [4, 5]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_range' => [6, 7]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIn()
    {
        $conditions = ['integer_in' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_in' => []];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_in' => [4, 5, 6]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_in' => [6, 7, 8]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsNull()
    {
        $conditions = ['integer_is_null' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_is_null' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_is_null' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsNotNull()
    {
        $conditions = ['integer_is_not_null' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_is_not_null' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['integer_is_not_null' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsTrue()
    {
        $conditions = ['boolean_is_true' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_true' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_true' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsNotTrue()
    {
        $conditions = ['boolean_is_not_true' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_not_true' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_not_true' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsFalse()
    {
        $conditions = ['boolean_is_false' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_false' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_false' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testIsNotFalse()
    {
        $conditions = ['boolean_is_not_false' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_not_false' => true];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['boolean_is_not_false' => false];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testDateRange()
    {
        $conditions = ['date_range' => []];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [null, null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-01-01')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-01-01'), null]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [null, new Carbon('2000-12-31')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-01-01'), new Carbon('2000-12-31')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-09-15'), new Carbon('2000-12-31')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-01-01'), new Carbon('2000-09-15')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-09-16'), new Carbon('2000-12-31')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());

        $conditions = ['date_range' => [new Carbon('2000-01-01'), new Carbon('2000-09-14')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testDateTimeRange()
    {
        $conditions = ['datetime_range' => []];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [null, null]];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-01-01 00:00:00')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-01-01 00:00:00'), null]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [null, new Carbon('2000-12-31 23:59:59')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-01-01 00:00:00'), new Carbon('2000-12-31 23:59:59')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-09-15 12:30:30'), new Carbon('2000-12-31 23:59:59')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-01-01 00:00:00'), new Carbon('2000-09-15 12:30:31')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-09-15 12:30:31'), new Carbon('2000-12-31 23:59:59')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());

        $conditions = ['datetime_range' => [new Carbon('2000-01-01 00:00:00'), new Carbon('2000-09-15 12:30:30')]];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testCustomFunction()
    {
        $conditions = ['text_custom_function' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_custom_function' => 'function'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['text_custom_function' => 'noitcnuf'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testKeyword()
    {
        $conditions = ['keyword' => null];
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['keyword' => 'equals contains startswith endswith function'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = ['keyword' => 'this is not invalid keywords'];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testRelation()
    {
        $conditions = [];
        array_set($conditions, 'parent.text_equals', null);
        $query = Dummy::search($conditions);
        $this->assertFalse($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = [];
        array_set($conditions, 'parent.text_equals', 'equals');
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions = [];
        array_set($conditions, 'parent.text_equals', 'not equals');
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }

    /** @test */
    public function testCombination()
    {
        $conditions = [
            'keyword' => 'equals contains startswith endswith',
            'text_equals' => 'equals',
            'text_contains' => 'contains',
            'text_startswith' => 'startswith',
            'text_endswith' => 'endswith',
            'integer_gt' => 4,
            'integer_gte' => 5,
            'integer_lt' => 6,
            'integer_lte' => 5,
            'integer_range' => [4, 6],
            'integer_in' => [4, 5, 6],
            'integer_is_null' => true,
            'integer_is_not_null' => true,
            'boolean_is_true' => true,
            'boolean_is_not_true' => true,
            'boolean_is_false' => true,
            'boolean_is_not_false' => true,
            'date_range' => [new Carbon('2000-01-01'), new Carbon('2000-12-31')],
            'datetime_range' => [new Carbon('2000-01-01 00:00:00'), new Carbon('2000-12-31 23:59:59')],
            'text_custom_function' => 'function',
            'parent' => [
                'text_equals' => 'equals',
                'text_contains' => 'contains',
                'text_startswith' => 'startswith',
                'text_endswith' => 'endswith',
                'integer_gt' => 4,
                'integer_gte' => 5,
                'integer_lt' => 6,
                'integer_lte' => 5,
                'integer_range' => [4, 6],
                'integer_in' => [4, 5, 6],
                'integer_is_null' => true,
                'integer_is_not_null' => true,
                'boolean_is_true' => true,
                'boolean_is_not_true' => true,
                'boolean_is_false' => true,
                'boolean_is_not_false' => true,
                'date_range' => [new Carbon('2000-01-01'), new Carbon('2000-12-31')],
                'datetime_range' => [new Carbon('2000-01-01 00:00:00'), new Carbon('2000-12-31 23:59:59')],
                'text_custom_function' => 'function',
            ]
        ];
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertTrue($query->exists());

        $conditions['text_equals'] = 'not equals';
        $query = Dummy::search($conditions);
        $this->assertTrue($this->isNotDefaultQuery($query));
        $this->assertFalse($query->exists());
    }
}
