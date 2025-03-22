<?php

namespace App\Traits\Collection;

use App\Collections\SupportCollection;

trait Searching
{
    public function searchingCallMethod($method, $args)
    {
        return $this->magicWhere(snake_case($method), $args);
    }

    /**
     * Turn the magic getWhere into a real where query.
     *
     * @param $method
     * @param $args
     *
     * @return Collection
     */
    private function magicWhere($method, $args)
    {
        $whereStatement = SupportCollection::explode('_', $method);

        // Get where
        if ($whereStatement->count() == 2) {
            return $this->performGetWhere($args[0], '=', $args[1]);
        }

        $operators = new self([
            'in', 'between', 'like', 'null',
            'not',
            'first', 'last',
            'many',
        ]);

        // If an operator is found then add operators.
        if ($whereStatement->intersect($operators)) {
            list($operator, $firstOrLast, $inverse) = $this->determineMagicWhereDetails($whereStatement);

            $column = $args[0];
            $value  = (isset($args[1]) ? $args[1] : null);

            return $this->performGetWhere(
                $column,
                $operator,
                $value,
                $inverse,
                $firstOrLast
            );
        }
    }

    /**
     * @param $whereStatement
     *
     * @return array
     */
    private function determineMagicWhereDetails($whereStatement)
    {
        $finalOperator = $whereStatement->intersect(['in', 'between', 'like', 'null', '='])
                                        ->pipe(function ($collection) {
                                            return $collection->count() ? $collection->first() : '=';
                                        });

        $position = $whereStatement->intersect(['first', 'last'])
                                   ->pipe(function ($collection) {
                                       return $collection->count() ? $collection->first() : null;
                                   });

        $not = $whereStatement->intersect(['not'])
                              ->pipe(function ($collection) {
                                  return $collection->count() ? $collection->first() : false;
                              });

        return [$finalOperator, $position, $not];

        // This is not working at the moment
        // todo riddles - fix this
        //if ($finalOperator == 'many') {
        //    $where = null;
        //    foreach ($args[0] as $column => $value) {
        //        $where = $this->getWhere(
        //            $column,            // Column
        //            $finalOperator,    // Operator
        //            $value,             // Value
        //            $not,               // Inverse
        //            $position            // First or last
        //        );
        //    }
        //
        //    return $where;
        //}
    }

    /**
     * Search a collection for the value specified.
     *
     * @param  string  $column   The column to search.
     * @param  string  $operator The operation to use during search.
     * @param  mixed   $value    The value to search for.
     * @param  boolean $inverse  Invert the results.
     * @param  string  $position Return the first or last object in the collection.
     *
     * @return self              Return the filtered collection.
     */
    protected function performGetWhere($column, $operator, $value = null, $inverse = false, $position = null)
    {
        $output = clone $this;

        // Handle multi-tapping version if needed.
        if (strstr($column, '->')) {
            $output = $output->filter(function ($item) use ($column, $value, $operator, $inverse) {
                return ! $this->handleMultiTap($item, $column, $value, $operator, $inverse);
            });

            return $this->setOutputByPosition($output, $position);
        }

        // Go directly to the whereObject.
        $output = $output->filter(function ($item) use ($column, $value, $operator, $inverse) {
            return ! $this->whereObject($item, $column, $operator, $value, $inverse);
        });

        return $this->setOutputByPosition($output, $position);
    }

    /**
     * Return the results of the search.  Either all of the results
     * or only the one at the position specified.
     *
     * @param collection $output   The collection that has been filtered by searching.
     * @param string     $position Return the first or last object in the collection.
     *
     * @return mixed
     */
    private function setOutputByPosition($output, $position)
    {
        // Handle first and last.
        if (! is_null($position)) {
            return $output->{$position}();
        }

        return $output;
    }

    /**
     * Compare the object and column passed with the value using the operator
     *
     * @param  object  $object   The object we are searching.
     * @param  string  $column   The column to compare.
     * @param  string  $operator What type of comparison operation to perform.
     * @param  mixed   $value    The value to search for.
     * @param  boolean $inverse  Invert the results.
     *
     * @return boolean           Return true if the object should be removed from the collection.
     */
    private function whereObject($object, $column, $operator, $value = null, $inverse = false)
    {
        // Remove the object if the column does not exist.
        // Only do this if we aren't looking for null
        if (isset($object->$column) === false && $operator != 'null') {
            return true;
        }

        $method = 'getWhere' . ucfirst($operator);

        if (method_exists($this, $method)) {
            return $this->{$method}($object, $column, $value, $inverse);
        }

        return $this->getWhereDefault($object, $column, $value, $inverse);
    }

    private function getWhereIn($object, $column, $value, $inverse)
    {
        if (! in_array($object->$column, $value) && $inverse == false) {
            return true;
        }

        if (in_array($object->$column, $value) && $inverse == true) {
            return true;
        }

        return false;
    }

    private function getWhereBetween($object, $column, $value, $inverse)
    {
        if (($object->$column < $value[0] || $object->$column > $value[1]) && $inverse == false) {
            return true;
        }

        if (($object->$column >= $value[0] && $object->$column <= $value[1]) && $inverse == true) {
            return true;
        }

        return false;
    }

    private function getWhereLike($object, $column, $value, $inverse)
    {
        if (! strstr($object->$column, $value) && $inverse == false) {
            return true;
        }

        if (strstr($object->$column, $value) && $inverse == true) {
            return true;
        }

        return false;
    }

    private function getWhereNull($object, $column, $value, $inverse)
    {
        if ((! is_null($object->$column) || $object->$column != null) && $inverse == false) {
            return true;
        }

        if ((is_null($object->$column) || $object->$column == null) && $inverse == true) {
            return true;
        }

        return false;
    }

    private function getWhereDefault($object, $column, $value, $inverse)
    {
        if ($object->$column != $value && $inverse == false) {
            return true;
        }

        if ($object->$column == $value && $inverse == true) {
            return true;
        }

        return false;
    }
}
