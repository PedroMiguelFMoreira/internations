<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 20:12
 */

namespace App\Repository;


use App\Models\Model;
use App\Repository\Contracts\Repository as RepositoryContract;
use Exception;

abstract class Repository implements RepositoryContract
{

    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param Model $abstractModel
     * @return bool
     */
    public function save(Model $abstractModel)
    {
        return $abstractModel->save();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $id
     * @return bool|null
     * @throws Exception
     */
    public function delete($id)
    {
        $this->model = $this->model->findOrFail($id);
        return $this->model->delete();
    }

    /**
     * @return mixed
     */
    protected abstract function model();

}