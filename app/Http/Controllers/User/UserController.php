<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $repository;

    public function __construct() {
        $this->middleware('auth:api');
        $this->repository = app()->make('App\Repositories\Users\UserRepositoryInterface');
    }

    public function all() {
        $users = $this->repository->with(['roles'])
            ->orderby('created_at', 'desc')
            ->all();

        return response()->json($users);
    }

    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles' => 'required',
        ]);

        $data = $request->all();
        $user = $this->repository->create($data);

        return response()->json($user);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $user = $this->repository->update($id, $data);
        return response()->json($user);
    }

    
    public function edit(int $id) {
        $user = $this->repository->with(['roles'])->find($id);
        return response()->json($user);
    }

    public function delete(int $id) {
        if (auth()->user()->id == $id) {
            $msg['msg'] = 'Exclusion not allowed.';
            return response()->json($msg, 400);
        }

        $this->repository->delete($id);
        return response()->json('User removed successfully.');
    }
}
