<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function name($name)
    {
        return $this->where('name', 'like', "%$name%");
    }

    public function email($email)
    {
        return $this->where('email', 'like', "%$email%");
    }

    public function phone($phone)
    {
        return $this->where('phone', 'like', $phone);
    }
}
