<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends CrudRepository
{

    public function model()
    {
       return Role::class;
    }
}
