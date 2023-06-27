<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait FillableColumns
{
    public function getFillableColumns()
    {
        $attributes = Schema::getColumnListing($this->getTable());
        return array_values(array_filter($attributes, fn ($value) => !in_array($value, $this->getGuarded()) || in_array($value, $this->getFillable())));
    }
}
