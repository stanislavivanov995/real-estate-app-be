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
http://localhost:8000/api/real-estates?latitude=42.62572623948879&longitude=23.37424375225898&radius=500&sort[by]=price&sort[order]=asc&min_price=20
*/