<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

abstract class InertiaController extends BaseController
{
    /**
     * Set the page title for use in the header.
     *
     * @param string $title
     */
    protected function setPageTitle($title)
    {
        $this->setJavascriptData(compact('title'));
    }

    /**
     * Pass data directly to Javascript.
     *
     * @link https://github.com/laracasts/PHP-Vars-To-Js-Transformer
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected function setJavascriptData($key, $value = null)
    {
        Inertia::share($key, $value);
    }

    /**
     * Send data to inertia.
     *
     * @param string $vue
     * @param array  $data
     *
     * @return \Inertia\Response
     */
    public function render($vue, $data = [])
    {
        return Inertia::render($vue, $data);
    }

    /**
     * Helper for common ajax call controller methods.
     *
     * @param callable $callback
     * @param array    $extras
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxResponse(callable $callback, $extras = [])
    {
        try {
            $successMessage = $callback();
        } catch (\Exception $exception) {
            return $this->error($exception);
        }

        return $this->success($successMessage, $extras);
    }

    /**
     * Return an error response for ajax calls.
     *
     * @param string|\Exception $message
     * @param int               $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $code = 400)
    {
        if ($message instanceof \Exception) {
            $exception = $message;
            $message   = $exception->getMessage();
            $code      = $exception->getCode();

            if ($code == 0) {
                $code = 400;
            }

            if ($code == 23000) {
                $code = 500;
            }

            // Unable to connect to redis
            if ($code == 10061) {
                $code = 500;
            }
        }

        return response()->json(compact('message'), $code);
    }

    /**
     * Return a successful response for ajax calls.
     *
     * @param string $message
     * @param array  $extras
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message, $extras = [])
    {
        $result = compact('message');

        if (! empty($extras)) {
            $result = $result + $extras;
        }

        return response()->json($result, 200);
    }
}
