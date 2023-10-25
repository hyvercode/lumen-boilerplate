<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Telemetri extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'telemetris';

    protected $guarded = [];
    public $timestamps = false;
}
