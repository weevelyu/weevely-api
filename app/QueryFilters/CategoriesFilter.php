<?php

namespace App\QueryFilters;

use Kblais\QueryFilter\QueryFilter;

class CategoriesFilter extends QueryFilter
{
    public function search(string $value)
    {
        return $this->where('title', 'LIKE', '%' . $value . '%');
    }
    public function limit(int $value)
    {
        return $this->take($value)->get();
    }
    public function random(int $value)
    {
        return $this->inRandomOrder()->limit($value)->get();
    }
}
