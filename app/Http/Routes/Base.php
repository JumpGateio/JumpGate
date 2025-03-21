<?php

namespace App\Http\Routes;

abstract class Base
{
    public ?string $namespace = null;

    public ?string $prefix = null;

    public ?String $context = null;

    public array $contexts = [
        'admin'   => '/admin',
        'default' => '/',
    ];

    public array $middleware = [];

    public array $patterns = [];

    public ?string $role = null;

    public array $permissions = [];

    /**
     * Add a context to the array.
     *
     * @param string $name
     * @param string $uri
     *
     * @return Base
     */
    public function setContext(string $name, string $uri): self
    {
        $this->contexts[$name] = $uri;

        return $this;
    }

    /**
     * Get a context URI from the array.
     *
     * @param string|null $name
     *
     * @return ?string
     */
    public function getContext(?string $name = null): ?string
    {
        if (is_null($name)) {
            $name = $this->context;
        }

        return $this->contexts[$name] ?? null;
    }

    /**
     * Get the namespace for this route group.
     *
     * @return ?string
     */
    public function getNamespace(): ?string
    {
        if (! is_string($this->namespace)) {
            return null;
        }

        return $this->namespace;
    }

    /**
     * Get the prefix for this route group.
     *
     * @return ?string
     */
    public function getPrefix(): ?string
    {
        $prefix = null;

        if (! is_null($this->getContext())) {
            $prefix = $this->getContext();
        }

        if (! is_string($this->prefix)) {
            return $prefix;
        }

        return $prefix . $this->prefix;
    }

    /**
     * Get the middleware for this route group.
     *
     * @return ?array
     */
    public function getMiddleware(): ?array
    {
        if (! is_array($this->middleware)) {
            return null;
        }

        return $this->middleware;
    }

    /**
     * Get the patterns for this route group.
     *
     * @return ?array
     */
    public function getPatterns(): ?array
    {
        if (! is_array($this->patterns)) {
            return null;
        }

        return $this->patterns;
    }

    /**
     * Get the roles required for this route group.
     *
     * @return ?array
     */
    public function getRole(): ?array
    {
        return $this->role;
    }

    /**
     * Get the roles required for this route group.
     *
     * @return ?array
     */
    public function getPermissions(): ?array
    {
        if (! is_array($this->permissions)) {
            return null;
        }

        return implode(', ', $this->permissions);
    }
}
