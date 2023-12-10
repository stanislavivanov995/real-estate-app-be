<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;


class EstatesFilter extends Filter
{
    public function description(string $value = null): Builder
    {
        return $this->builder->where('description', 'like', "%{$value}%");
    }


    public function category(string $value = null): Builder
    {
        return $this->builder->where('category_id', 'like', "%{$value}%");
    }


    public function min_price(string $value = null): Builder
    {
        return $this->builder->where('price', '>=', $value);
    }

    
    public function max_price(string $value = null): Builder
    {
        return $this->builder->where('price', '<=', $value);
    }


    public function min_rooms(string $value = null): Builder
    {
        return $this->builder->where('rooms', '>=', $value);
    }


    public function max_rooms(string $value = null): Builder
    {
        return $this->builder->where('rooms', '<=', $value);
    }

    
    public function sort(array $value = []): Builder
    {
        if (isset($value['by']) && ! Schema::hasColumn('estates', $value['by'])) {
            return $this->builder;
        }

        return $this->builder->orderBy(
            $value['by'] ?? 'created_at', $value['order'] ?? 'desc'
        );
    }
}

/*
/estates?sort[by]=price&sort[order]=asc&category=1&description=Stu
*/