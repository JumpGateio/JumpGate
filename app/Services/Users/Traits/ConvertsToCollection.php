<?php

namespace App\Services\Users\Traits;

use Illuminate\Database\Eloquent\Collection;
use JumpGate\Database\Collections\EloquentCollection;

trait ConvertsToCollection
{
    /**
     * Use the custom collection that allows tapping.
     *
     * @param array $models An array of models to turn into a collection.
     *
     * @return Collection|EloquentCollection
     */
    public function newCollection(array $models = []): Collection|EloquentCollection
    {
        if (app(config('auth.providers.users.model'))->jumpGateCollections) {
            return new EloquentCollection($models);
        }

        return parent::newCollection($models);
    }
}
