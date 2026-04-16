<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'ext_id'];

    public function getRouteKeyName()
    {
        return 'ext_id';
    }

    public function cltLayups()
    {
        return $this->hasMany(CLTLayup::class);
    }
}
