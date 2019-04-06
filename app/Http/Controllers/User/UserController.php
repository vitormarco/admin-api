<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $repository;

    public function __contruct() {
        $this->repository = app()->make('App\Repositories\Users\UserRepositoryInterface');
    }

    public function all() {
        dd($this->repository);
        $users = $this->repository->with(['roles'])
            ->orderby('created_at', 'desc')
            ->all();

        return response()->json($users);
    }
}
