<?php

namespace App\Actions;

use App\Managers\Response;

class Destructive
{
    public mixed $model;

    public string $status;

    public int $action;

    public string $method;

    private string $returnUrl;

    public function __construct($model, $status, $action, $returnUrl)
    {
        $this->model     = $model;
        $this->status    = $status;
        $this->action    = (int)$action;
        $this->returnUrl = $returnUrl;
    }

    /**
     * Determine what to do on the user.
     *
     * @return Response
     */
    public function execute(): Response
    {
        $this->determineMethod();

        $this->model->{$this->method}();

        return Response::passed($this->getMessage())
            ->route($this->returnUrl);
    }

    /**
     * Based on the status and action, determine the method
     * to call on the user object.
     */
    protected function determineMethod(): void
    {
        $methods = [
            'delete' => ['restore', 'delete'],
        ];

        $this->method = array_get($methods, $this->status . '.' . $this->action);
    }

    /**
     * Based on the method, determine a logic message
     * to display when redirecting.
     *
     * @return string
     */
    protected function getMessage(): string
    {
        return match ($this->method) {
            default => get_class($this->model) . ' ' . $this->method . 'd.',
        };
    }
}
