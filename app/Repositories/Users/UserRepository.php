<?php

namespace App\Repositories\Users;

use App\Models\Role;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        $this->model = app()->make('App\Models\User');
    }

    public function create(array $data) {

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $user = $this->model->create($data);

        foreach ($data['roles'] as $role) {
            $roles = Role::find($role['id']);
            if ($roles) {
                $user->roles()->attach($roles);
            }
        }

        return $user;
    }

    public function update(int $id, array $data) {

        $user = $this->model->find($id);

        if (empty($data['password']) || is_null($data['password'])) {
            $data['password'] = $user->password;
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $user->update($data);

        foreach ($data['roles'] as $role) {
            $roles = Role::find($role['id']);
            if ($roles) {
                $user->roles()->detach();
                $user->roles()->attach($roles);
            }
        }

        return $user;
    }

}
