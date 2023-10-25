<?php

namespace App\Models;

use App\Utils\CommonUtil;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes, HasFactory, HasRoles;


    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'username', 'email', 'password', 'api_roles', 'status', 'branch_id', 'company_id', 'phone_number', 'employee_id', 'coordinate', 'fcm_token', 'created_at', 'created_by', 'updated_at', 'updated_by','avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
//    protected $hidden = [
//        'password',
//    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            "scope" => $this->api_roles,
            "company" => $this->company_id,
            "employee" => $this->employee_id,
            "branch" => $this->branch_id,
            "roles" => $this->menu_roles,
            "api_roles" => $this->api_roles,
            "avatar" => $this->avatar,
            "name" => $this->name,
            "login_id" => CommonUtil::generateUUID()
        ];
    }

    protected $guard_name = 'api';
    protected $guarded = [];
    protected $attributes = [
        'menu_roles' => 'user',
    ];
}
