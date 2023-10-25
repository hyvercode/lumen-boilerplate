<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Loggers extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'loggers';

    protected $guarded = [];
    public $timestamps = false;
}
