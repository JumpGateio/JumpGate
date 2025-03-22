<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\Traits\Collection\Chaining;
use App\Traits\Collection\Helpers;
use App\Traits\Collection\Searching;

/**
 * Class Collection
 *
 * This class adds some magic to the collection class.
 * It allows you to tab through collections into other object or collections.
 * It also allows you to run a getWhere on a collection to find objects.
 *
 * @method getWhere(string $column, string $values)
 * @method getWhereNot(string $column, string $values)
 *
 * @method getWhereIn(string $column, array $values)
 * @method getWhereInFirst(string $column, array $values)
 * @method getWhereInLast(string $column, array $values)
 * @method getWhereNotIn(string $column, array $values)
 *
 * @method getWhereBetween(string $column, array $values)
 * @method getWhereNotBetween(string $column, array $values)
 *
 * @method getWhereLike(string $column, string $values)
 * @method getWhereNotLike(string $column, string $values)
 *
 * @method getWhereNull(string $column)
 * @method getWhereNotNull(string $column)
 *
 * @method getWhereMany(array $column)
 */
class EloquentCollection extends Collection
{
    /**
     * Allow relationship chaining.
     */
    use Chaining;

    /**
     * Add get where searching to collection
     */
    use Searching;

    /**
     * Adds extra functionality to collections.
     */
    use Helpers;

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        // Chaining
        return $this->chainingGetMethod($key);
    }


    /**
     * Allow a method to be run on the entire collection.
     *
     * @param string $method
     * @param array  $args
     *
     * @return Collection
     */
    public function __call($method, $args)
    {
        // No data in the collection.
        if ($this->count() <= 0) {
            return $this;
        }

        // Look for magic where calls.
        if (strstr($method, 'getWhere')) {
            return $this->searchingCallMethod($method, $args);
        }

        // Run the command on each object in the collection.
        return $this->chainingCallMethod($method, $args);
    }
}
