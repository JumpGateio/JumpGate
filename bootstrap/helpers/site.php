<?php

function dir_style($parts): string
{
    // This site is developed on windows but presented on linux.
    $ending = '/';
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $ending = '\\';
    }

    return implode($ending, $parts);
}
