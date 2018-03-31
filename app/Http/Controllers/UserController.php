<?php
/**
 * Created by PhpStorm.
 * User: Pedro Moreira
 * Date: 28/03/2018
 * Time: 19:25
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\Contracts\Repository;
use App\Repository\Contracts\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function authenticate(Request $request) {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = $this->repository()->findByEmail($request->input('email'));

            if (Hash::check($request->input('password'), $user->password)) {
                $apiKey = base64_encode(str_random(40));
                $user->api_key = $apiKey;
                $this->repository()->save($user);

                return response()->json(['api_key' => $apiKey]);
            } else {
                return response()->json(['error' => 'Invalid credentials.'],500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function create(Request $request) {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));

            if ($this->repository()->save($user)) {
                return response()->json(null, 201);
            }

            return response()->json(null, 500);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function delete($id) {
        try {
            if($this->repository()->delete($id)) {
                return response()->json(null, 200);
            } else {
                return response()->json(['error' => 'Unable to delete record.'], 500);
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function addToGroup(Request $request) {
        try {
            $this->validate($request, [
                'user' => 'required|numeric',
                'groups' => 'required|array'
            ]);

            $user = $this->repository()->findById($request->input('user'));
            foreach ($request->input('groups') as $groupId) {
                $user->groups()->attach($groupId);
            }

            $this->repository()->save($user);

            return response()->json(null, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function removeFromGroup(Request $request) {
        try {
            $this->validate($request, [
                'user' => 'required|numeric',
                'groups' => 'required|array|min:1'
            ]);

            $user = $this->repository()->findById($request->input('user'));
            foreach ($request->input('groups') as $groupId) {
                $user->groups()->detach($groupId);
            }

            $this->repository()->save($user);

            return response()->json(null, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @return Repository|UserRepository
     */
    protected function repository()
    {
        return $this->repository;
    }

}