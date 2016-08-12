<?php

use NukaCode\Core\Database\Collection;

if (! function_exists('start_Debug')) {
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
        if (app()->environment('local') || Input::get('debug') == true) {
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
        if (app()->environment('local') || Input::get('debug') == true) {
            stop_measure($name);
        }
    }
}

if (! function_exists('collector')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed $value
     *
     * @return \Illuminate\Support\Collection
     */
    function collector($value = null)
    {
        return new Collection($value);
    }
}

if (! function_exists('cache')) {
    /**
     * Get / set the specified cache value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  int    $minutes
     *
     * @return mixed
     */
    function cache($key = null, $value = null, $minutes = null)
    {
        if (is_null($key)) {
            return app('cache');
        }

        if (! is_null($value) && ! is_null($minutes)) {
            return app('cache')->put($key, $value, $minutes);
        }

        return app('cache')->get($key);
    }
}

if (! function_exists('pp')) {
    /**
     * Print Pre data.
     *
     * @param mixed $data   The data you would like to display
     * @param bool  $return Return the data instad of echoing it.
     *
     * @return string $output The data to display wrapped in pre tags.
     */
    function pp($data, $return = false)
    {
        $output = '<pre>';
        $output .= print_r($data, true);
        $output .= '</pre>';

        if ($return == true) {
            return $output;
        } else {
            echo $output;
        }
    }
}

if (! function_exists('ppd')) {
    /**
     * Print Pre and die.
     *
     * @param mixed $data The data you would like to display
     *
     * @return void
     */
    function ppd($data)
    {
        $output = '<pre>';
        $output .= print_r($data, true);
        $output .= '</pre>';

        echo $output;
        die;
    }
}

if (! function_exists('classify')) {
    /**
     * Converts a string into a class name.
     * Hello world would become Hello_World.
     *
     * @param $value
     *
     * @return mixed
     */
    function classify($value)
    {
        $value  = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
        $search = ['_', '-', '.', '/', ':'];

        return str_replace(' ', '_', str_replace($search, ' ', $value));
    }
}

if (! function_exists('humanReadableImplode')) {
    /**
     * Implode an array but add 'and' before the last result.
     *
     * @param $array
     *
     * @return string
     */
    function humanReadableImplode($array, $separator = 'and')
    {
        $last  = array_slice($array, -1);
        $first = implode(', ', array_slice($array, 0, -1));
        $both  = array_filter(array_merge([$first], $last));

        return implode(" $separator ", $both);
    }
}
