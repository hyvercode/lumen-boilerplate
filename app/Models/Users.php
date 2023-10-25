<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden=['deleted_at'];
    /**
     * Get the notes for the users.
     */
    public function notes()
    {
        return $this->hasMany('App\Notes');
    }

    protected $dates = [
        'deleted_at'
    ];
}
