<?php

namespace App\Services\JumpGate\Core\Collections\Providers;

use Illuminate\Support\Collection;

class Search
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|\App\Services\JumpGate\Core\Collections\Contracts\Searchable
     */
    public $model;

    /**
     * @var \Illuminate\Database\Eloquent\Model|\App\Services\JumpGate\Core\Collections\Contracts\Searchable||\Illuminate\Database\Eloquent\Collection
     */
    public $search;

    public function __construct($model)
    {
        $this->setModel($model);
    }

    public function search(Collection $parameters)
    {
        $parameters->each(function ($value, $parameter) {
            // Custom searches.
            if (method_exists($this, $parameter)) {
                return $this->{$parameter}($value);
            }

            // Relationships.
            if (method_exists($this->model, $parameter)) {
                return $this->whereHas($parameter, $value);
            }

            // Generic searches.
            return $this->where($parameter, $value);
        });

        // $orderBy        = request('orderBy', $this->model->defaultOrderBy);
        // $orderDirection = request('orderDirection', $this->model->defaultOrderDirection);

        // return $this->search->orderBy($orderBy, $orderDirection);
        return $this->search;
    }

    /**
     * Search a column on the model.
     *
     * @param $parameter
     * @param $value
     *
     * @return bool
     */
    public function where($parameter, $value)
    {
        if (! $this->verify($parameter, $value)) {
            return true;
        }

        $this->search = $this->search
            ->where($parameter, 'LIKE', '%' . $value . '%');
    }

    /**
     * Search the model for a particular relationship.
     * This method expects to be passed the ID, but
     * the parameter name should be the relationship name.
     *
     * @param $parameter
     * @param $value
     *
     * @return bool
     */
    public function whereHas($parameter, $value)
    {
        if (! $this->verify($parameter, $value)) {
            return true;
        }

        $this->search = $this->search
            ->whereHas($parameter, function ($query) use ($value) {
                $query->where('rbac_roles.id', $value);
            });
    }

    /**
     * Check if the given value is actually empty.
     * This aims to help with discrepancies caused by form submission.
     *
     * @param string $parameter
     * @param string $value
     *
     * @return bool
     */
    protected function verify($parameter, $value)
    {
        $type = array_get($this->model->getSearchParameters(), $parameter);

        switch ($type) {
            case 'array':
                $typeCheck = is_array($value) && ! empty(array_filter($value));
                break;
            case 'string':
                $typeCheck = ! is_numeric($value) && is_string($value) && $value !== '';
                break;
            case 'bool':
            case 'boolean':
                $typeCheck = $value != '' && (int)$value !== 2 && in_array((int)$value, [0, 1]);
                break;
            case 'int':
            case 'integer':
                $typeCheck = is_numeric($value) && (int)$value > 0;
                break;
        }

        return ! is_null($value) && $typeCheck;
    }

    /**
     * Set the model and the search builder.
     *
     * @param object $model
     */
    protected function setModel($model)
    {
        $this->model  = $model;
        $this->search = $model;
    }
}
