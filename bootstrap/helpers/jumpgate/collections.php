<?php

use App\Collections\EloquentCollection;
use App\Collections\SupportCollection;

if (! function_exists('collector')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed $value
     *
     * @return EloquentCollection
     */
    function collector(mixed $value = null): EloquentCollection
    {
        return new EloquentCollection($value);
    }
}

if (! function_exists('supportCollector')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed $value
     *
     * @return SupportCollection
     */
    function supportCollector(mixed $value = null): SupportCollection
    {
        return new SupportCollection($value);
    }
}
