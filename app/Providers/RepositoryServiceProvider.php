<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 29/03/2018
 * Time: 10:27
 */

namespace App\Providers;

use App\Repository\Contracts\GroupRepository as GroupRepositoryContract;
use App\Repository\Contracts\UserRepository as UserRepositoryContract;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register() {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(GroupRepositoryContract::class, GroupRepository::class);
    }

}