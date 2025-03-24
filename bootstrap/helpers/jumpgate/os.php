<?php

if (! function_exists('dir_style')) {
    /**
     * Determine the correct directory style based on OS.
     *
     * @param array $directories
     *
     * @return string
     */
    function dir_style(array $directories): string
    {
        // This site is developed on windows but presented on linux.
        $ending = '/';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ending = '\\';
        }

        return implode($ending, $directories);
    }
}
