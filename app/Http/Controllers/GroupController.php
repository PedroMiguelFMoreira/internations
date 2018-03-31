<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 19:25
 */

namespace App\Http\Controllers;


use App\Models\Group;
use App\Repository\Contracts\GroupRepository;
use App\Repository\Contracts\Repository;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function __construct(GroupRepository $repository)
    {
        $this->middleware('auth');
        parent::__construct($repository);
    }

    public function create(Request $request) {
        try {
            $this->validate($request, [
               'name' => 'required'
            ]);

            $group = new Group();
            $group->name = $request->input('name');
            $group->description = $request->input('description');

            if ($this->repository()->save($group)) {
                return response()->json(null, 201);
            }

            return response()->json(null, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            if ($this->repository()->delete($id)) {
                return response()->json(null, 200);
            }

            return response()->json(['error' => 'Unable to delete record.'], 500);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @return GroupRepository|Repository
     */
    protected function repository()
    {
        return $this->repository;
    }
}
