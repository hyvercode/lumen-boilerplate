<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CrudRepository
{

    public function model()
    {
        return User::class;
    }

    /**
     * @param $username
     * @return User
     */
    public function findUserByUsername($username)
    {
        return User::select('id', 'menu_roles as roles', 'branch_id', 'company_id', 'status', 'api_roles', 'username', 'phone_number', 'email')->where('username', '=', $username)->first();
    }

    /**
     * @param $username
     * @return User
     */
    public function findUserByPhoneNumber($phone_number)
    {
        return User::select('id', 'menu_roles as roles', 'branch_id', 'company_id', 'status', 'api_roles', 'phone_number', 'email')
            ->where('phone_number', '=', $phone_number)->first();
    }

    public function findUserById($user_id)
    {
        return User::where('id', $user_id)
            ->get(['users.id', 'users.name', 'users.email', 'status'])->first();
    }

    public function findUserByIdAndCompany($user_id, $company_id)
    {
        return User::where('id', $user_id)
            ->where('company_id', $company_id)
            ->get(['id', 'name','username','email', 'status','phone_number'])->first();
    }
}
