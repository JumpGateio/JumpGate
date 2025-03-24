<?php

namespace App\Services\JumpGate\Core\Collections\Traits;

trait CanSearch
{
    public function getSearchProvider()
    {
        if (! isset($this->searchProvider) || is_null($this->searchProvider)) {
            throw new \Exception('You must set a search provider on your model.');
        }

        return new $this->searchProvider($this);
    }

    public function getSearchParameters()
    {
        if (! isset($this->searchParameters) || is_null($this->searchParameters) || empty($this->searchParameters)) {
            throw new \Exception('You must set the available search parameters on your model.');
        }

        return $this->searchParameters;
    }

    public function search($parameters)
    {
        $parameters = collect($parameters)
            ->only(array_keys($this->getSearchParameters()));

        $searchProvider = $this->getSearchProvider();

        return $searchProvider->search($parameters);
    }
}
