<?php

if (!function_exists('classify')) {
    /**
     * Converts a string into a class name.
     * Hello world would become Hello_World.
     *
     * @param $value
     *
     * @return mixed
     */
    function classify($value): mixed
    {
        $value  = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
        $search = ['_', '-', '.', '/', ':'];

        return str_replace(' ', '_', str_replace($search, ' ', $value));
    }
}

if (!function_exists('humanReadableImplode')) {
    /**
     * Implode an array but add 'and' before the last result.
     *
     * @param        $array
     * @param string $separator
     *
     * @return string
     */
    function humanReadableImplode($array, string $separator = 'and'): string
    {
        $last  = array_slice($array, -1);
        $first = implode(', ', array_slice($array, 0, -1));
        $both  = array_filter(array_merge([$first], $last));

        return implode(" $separator ", $both);
    }
}

if (!function_exists('json_validate')) {
    /**
     * Validate that JSON is properly set up and display
     * readable errors if not.
     *
     * @param $string
     *
     * @return mixed
     */
    function json_validate($string): mixed
    {
        // decode the JSON data
        $result = json_decode($string);

        // switch and check possible JSON errors
        $error = match (json_last_error()) {
            JSON_ERROR_NONE             => '',
            JSON_ERROR_DEPTH            => 'The maximum stack depth has been exceeded.',
            JSON_ERROR_STATE_MISMATCH   => 'Invalid or malformed JSON.',
            JSON_ERROR_CTRL_CHAR        => 'Control character error, possibly incorrectly encoded.',
            JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON.',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
            JSON_ERROR_RECURSION        => 'One or more recursive references in the value to be encoded.',
            JSON_ERROR_INF_OR_NAN       => 'One or more NAN or INF values in the value to be encoded.',
            JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
            default                     => 'Unknown JSON error occurred.',
        };

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            exit($error);
        }

        // everything is OK
        return $result;
    }
}
