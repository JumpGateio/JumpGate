<?php

if (! function_exists('start_debug')) {
    /**
     * Start a debugbar measurement
     *
     * @param string $name
     * @param string $label
     *
     * @return mixed
     */
    function start_debug($name, $label)
    {
        if (app()->environment('local') && app()->bound('debugbar')) {
            start_measure($name, $label);
        }
    }
}

if (! function_exists('stop_debug')) {
    /**
     * Stop a debugbar measurement
     *
     * @param string $name
     *
     * @return mixed
     */
    function stop_debug($name)
    {
        if (app()->environment('local') && app()->bound('debugbar')) {
            stop_measure($name);
        }
    }
}

if (!function_exists('objToArray')) {
    /**
     * Convert an object into an array.
     *
     * @param $object
     *
     * @return array
     */
    function objToArray($object): array
    {
        $array = [];
        foreach ($object as $key => $value) {
            $key = snake_case($key);

            if (!is_object($value)) {
                $array[$key] = $value;
                continue;
            }

            foreach ($value as $valueKey => $valueValue) {
                $valueKey         = $key . '_' . $valueKey;
                $array[$valueKey] = $valueValue;
            }
        }

        return $array;
    }
}
