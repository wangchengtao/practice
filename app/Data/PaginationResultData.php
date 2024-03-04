<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PaginationResultData extends Data
{
    public int $current;

    public int $pageSize;

    public int $count;

    public mixed $list;

    public function __construct(int $current, int $pageSize, int $count, mixed $list)
    {
        $this->current = $current;
        $this->pageSize = $pageSize;
        $this->count = $count;
        $this->list = $list;
    }
}
