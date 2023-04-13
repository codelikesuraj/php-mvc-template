<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{   
    // protected $connection = 'default';

    // protected $table = 'table_name';

    protected $fillable = ['first_name', 'last_name'];

    public $timestamps = false;
}