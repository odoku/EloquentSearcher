<?php

namespace EloquentSearcher;

trait SearchableTrait
{
    public function scopeSearch($query, $conditions, $type = 'default')
    {
        $class = $this->getSearcherClass($type);
        $searcher = new $class();
        return $searcher->build($query, $conditions);
    }

    protected function getSearcherClass($type)
    {
        if (! is_array($this->searcher)) {
            $this->searcher = ['default' => $this->searcher];
        }
        return array_get($this->searcher, $type);
    }
}
