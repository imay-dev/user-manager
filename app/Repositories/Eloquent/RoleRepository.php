<?php

namespace App\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use App\Contracts\RoleContract;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends RepositoryAbstract implements RoleContract
{
    /**
     * @return string
     */
    public function entity()
    {
        return Role::class;
    }
}
