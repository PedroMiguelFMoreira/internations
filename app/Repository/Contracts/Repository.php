<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 20:10
 */

namespace App\Repository\Contracts;


use App\Models\Model;

interface Repository
{

    public function all();

    /**
     * @param Model $abstractModel
     * @return boolean
     */
    public function save(Model $abstractModel);

    /**
     * @param $id
     * @return Model | null
     */
    public function findById($id);

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id);

}