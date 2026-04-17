<?php

namespace App\Services;

class methodServices
{
    function store(\Illuminate\Database\Eloquent\Model $model, $data)
    {
        app($model)::create($data);
    }
}
