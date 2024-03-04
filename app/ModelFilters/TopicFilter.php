<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class TopicFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function title($title)
    {
        return $this->where('title', 'like', '%' . $title . '%');
    }

    public function category($categoryId)
    {
        return $this->where('category_id', $categoryId);
    }

    public function order($order)
    {
        if ($order === 'recent') {
            return $this->recent();
        }

        return $this->recentReplied();
    }
}
