<?php

namespace App\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use App\Contracts\UserContract;
use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends RepositoryAbstract implements UserContract
{
    /**
     * @return string
     */
    public function entity(): string
    {
        return User::class;
    }
}
