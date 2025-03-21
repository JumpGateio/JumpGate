<?php

namespace App\Managers;

class Response
{
    public bool $success;

    public ?string $route = null;

    public ?string $routeName = null;

    public ?string $message = null;

    public function __construct(bool $success, ?string $route = null, ?string $message = null)
    {
        $this->success = $success;
        $this->route   = $route;
        $this->message = $message;
    }

    /**
     * Create a passing response.
     *
     * @param null|string $message
     *
     * @return static
     */
    public static function passed(?string $message = null): static
    {
        return new static(true, null, $message);
    }

    /**
     * Create a failed response.
     *
     * @param null|string $message
     *
     * @return static
     */
    public static function failed(?string $message = null): static
    {
        return new static(false, null, $message);
    }

    /**
     * Add a route to redirect the request to.
     *
     * @param string $name
     * @param array  $details
     *
     * @return $this
     */
    public function route(string $name, array $details = []): self
    {
        $this->route     = route($name, $details);
        $this->routeName = $name;

        return $this;
    }

    /**
     * Redirect the request.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function redirect(): \Illuminate\Http\RedirectResponse
    {
        // Make sure we have a route.
        if (is_null($this->route)) {
            throw new \Exception('No route has been provided.  Please use route() to add one.');
        }

        // If this response passed, show the success message.
        if ($this->success) {
            return redirect($this->route)
                ->with('message', $this->message);
        }

        // If this response failed, show the error message.
        return redirect($this->route)
            ->with('error', $this->message);
    }

    /**
     * Redirect the request to the intended route or the provided one.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function redirectIntended(): \Illuminate\Http\RedirectResponse
    {
        // Make sure we have a route.
        if (is_null($this->route)) {
            throw new \Exception('No route has been provided.  Please use route() to add one.');
        }

        // If this response passed, show the success message.
        if ($this->success) {
            return redirect()
                ->intended($this->route)
                ->with('message', $this->message);
        }

        // If this response failed, show the error message.
        return redirect($this->route)
            ->with('error', $this->message);
    }
}
