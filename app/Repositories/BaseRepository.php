<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function all()
    {
        return $this->model->get();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findBy(string $attribute, string $value)
    {
        return $this->model->where($attribute, '=', $value)->first();
    }

    public function findAllBy(string $attribute, string $value)
    {
        return $this->model->where($attribute, '=', $value)->get();
    }

    public function paginate(int $page = 10)
    {
        return $this->model->paginate($page);
    }

    public function create(array $data)
    {
        try {
            $model = $this->model->create($data);
            $model = $model->fresh();
            return $model;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function createOrUpdate(array $data)
    {
        try {
            $model = $this->model->firstOrNew(['id' => @$data['id']]);
            $model->fill($data)->save();
            return $model;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update(int $id, array $data)
    {
        $m = $this->model->findOrFail($id);
        if ($m->update($data)) {
            return $m;
        }
        return false;
    }

    public function delete(int $id)
    {
        try {
            return $this->model->find($id)->delete();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function orderBy($orderBy)
    {
        if (is_string($orderBy)) {
            $orderBy = func_get_args();
        }

        $this->model = $this->model->orderBy($orderBy[0], isset($orderBy[1]) ? $orderBy[1] : 'asc');
        return $this;
    }
}
