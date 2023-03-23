<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{

    use SoftDeletes;

    protected $fillable = ['name'];

    public function propertyOption(){
        $this->hasMany(PropertyOption::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
