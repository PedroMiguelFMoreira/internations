<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 20:13
 */

namespace App\Repository\Contracts;


use App\Models\User;

interface UserRepository extends Repository
{

    /**
     * @param $email
     * @return User | null
     */
    public function findByEmail($email);

}