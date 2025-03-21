<?php

if (!function_exists('apiCall')) {
    /**
     * Wrap an API call's results in a model.
     *
     * @param \GuzzleHttp\Psr7\Response $call
     * @param null|string               $tap
     *
     * @return \App\Models\Simple
     */
    function apiCall(\GuzzleHttp\Psr7\Response$call, ?string $tap = null): \App\Models\Simple
    {
        $result = json_decode($call->getBody()->getContents());

        if (!is_null($tap)) {
            $result = $result->{$tap};
        }

        if (!is_array($result)) {
            $result = (array)$result;
        }

        return new \App\Models\Simple($result);
    }
}

if (!function_exists('apiCollection')) {
    /**
     * Wrap an API call's results in a model.
     *
     * @param \GuzzleHttp\Psr7\Response $call
     * @param null|string               $tap
     *
     * @return \JumpGate\Database\Collections\SupportCollection
     */
    function apiCollection($call, $tap = null)
    {
        $result = json_decode($call->getBody()->getContents());

        if (!is_null($tap)) {
            $result = $result->{$tap};
        }

        return supportCollector($result)
            ->transform(function ($item) {
                return new \App\Models\Simple((array)$item);
            });
    }
}
