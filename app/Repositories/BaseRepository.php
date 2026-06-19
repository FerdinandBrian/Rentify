<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Model $model, array $data)
    {
        $model->update($data);
        return $model->refresh();
    }

    /**
     * @inheritDoc
     */
    public function delete($model)
    {
        if ($model instanceof Model) {
            return $model->delete();
        }

        return $this->model->destroy($model);
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function paginateWithFilters(array $criteria, array $filters, int $perPage): LengthAwarePaginator
    {
        $query = $this->getFilterQuery();

        foreach ($filters as $filter) {
            $query = $filter->apply($query, $criteria);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get the base query builder instance for filtering.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getFilterQuery()
    {
        return $this->model->newQuery();
    }
}
