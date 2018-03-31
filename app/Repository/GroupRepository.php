<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 20:13
 */

namespace App\Repository;

use App\Models\Group;
use App\Repository\Contracts\GroupRepository as GroupRepositoryContract;
use Dotenv\Exception\ValidationException;
use Exception;

class GroupRepository extends Repository implements GroupRepositoryContract
{

    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $id
     * @return bool|null
     * @throws Exception
     */
    public function delete($id)
    {
        $this->model = $this->model->findOrFail($id);

        if ($this->model()->users()->count() > 0) {
            throw new ValidationException("Group must be empty before deletion.");
        }

        return $this->model->delete();
    }

    /**
     * @return Group|\App\Models\Model
     */
    protected function model()
    {
        return $this->model;
    }
}