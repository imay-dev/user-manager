<?php

namespace App\Repositories;


use Illuminate\Support\Arr;
use App\Contracts\{RepositoryContract, CriteriaContract};;
use Illuminate\Contracts\Container\BindingResolutionException;
use Mockery\Exception;

/**
 * Class RepositoryAbstract
 * @package App\Repositories
 */
class RepositoryAbstract implements RepositoryContract, CriteriaContract
{

    /**
     * @var
     */
    protected $entity;

    /**
     * RepositoryAbstract constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    private function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new Exception('No entity defined.');
        }

        return app()->make($this->entity());
    }


    /**
     * @param mixed ...$criteria
     *
     * @return $this|mixed
     */
    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }

        return $this;
    }



    /**
     * @return mixed
     */
    public function all()
    {
        return $this->entity->all();
    }

    /**
     * @param int $perPage
     *
     * @return mixed
     */
    public function paginate(int $perPage)
    {
        return $this->entity->paginate($perPage);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function store(array $attributes)
    {
        return $this->entity->create($attributes);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->entity->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        return $this->show($id)->update($attributes);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->show($id)->delete($id);
    }

}
