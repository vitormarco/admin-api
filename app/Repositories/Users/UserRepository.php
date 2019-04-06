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

    public function create(array $data)
    {

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $usuario = $this->model->create($data);

        foreach ($data['roles'] as $role) {
            $r = Role::find($role['id']);
            if ($r) {
                $usuario->roles()->attach($r);
            }
        }

        return $usuario;
    }

    public function getByRole(string $name)
    {
        $users = $this->model->whereHas('roles', function ($q) use ($name) {
            $q->where('name', $name);
        })->get();
        return $users;
    }

    public function update(int $id, array $data)
    {

        $usuario = $this->model->find($id);

        if (empty($data['password']) || is_null($data['password'])) {
            $data['password'] = $usuario->password;
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $usuario->update($data);

        foreach ($data['roles'] as $role) {
            $r = Role::find($role['id']);
            if ($r) {
                $usuario->roles()->detach();
                $usuario->roles()->attach($r);
            }
        }

        return $usuario;
    }

}
