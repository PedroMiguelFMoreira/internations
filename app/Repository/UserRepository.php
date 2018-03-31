<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 20:13
 */

namespace App\Repository;

use App\Models\User;
use \App\Repository\Contracts\UserRepository as UserRepositoryContract;

class UserRepository extends Repository implements UserRepositoryContract
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $email
     * @return User | null
     */
    public function findByEmail($email)
    {
        return $this->model()->where('email', $email)->firstOrFail();
    }

    /**
     * @return \App\Models\Model|User
     */
    protected function model()
    {
        return $this->model;
    }
}