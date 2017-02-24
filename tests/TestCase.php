<?php

namespace EloquentSearcher\Test;

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase()
    {
        $builder = $this->app['db']->connection()->getSchemaBuilder();

        $builder->create('dummies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('text_equals');
            $table->string('text_contains');
            $table->string('text_startswith');
            $table->string('text_endswith');
            $table->integer('integer_gt');
            $table->integer('integer_gte');
            $table->integer('integer_lt');
            $table->integer('integer_lte');
            $table->integer('integer_range');
            $table->integer('integer_in');
            $table->integer('integer_is_null')->nullable();
            $table->integer('integer_is_not_null')->nullable();
            $table->boolean('boolean_is_true');
            $table->boolean('boolean_is_not_true');
            $table->boolean('boolean_is_false');
            $table->boolean('boolean_is_not_false');
            $table->date('date_range');
            $table->datetime('datetime_range');
            $table->string('text_custom_function');
        });

        $dummy = Dummy::create([
            'text_equals' => 'equals',
            'text_contains' => 'xxxx contains xxxx',
            'text_startswith' => 'startswith xxxx',
            'text_endswith' => 'xxxx endswith',
            'integer_gt' => 5,
            'integer_gte' => 5,
            'integer_lt' => 5,
            'integer_lte' => 5,
            'integer_range' => 5,
            'integer_in' => 5,
            'integer_is_null' => null,
            'integer_is_not_null' => 5,
            'boolean_is_true' => true,
            'boolean_is_not_true' => false,
            'boolean_is_false' => false,
            'boolean_is_not_false' => true,
            'date_range' => new Carbon('2000-09-15'),
            'datetime_range' => new Carbon('2000-09-15 12:30:30'),
            'text_custom_function' => 'function',
        ]);
        $dummy->parent_id = $dummy->id;
        $dummy->save();
    }

    protected function showQuery($query)
    {
        \DB::enableQueryLog();
        $query->get();
        dd(\DB::getQueryLog());
    }
}
