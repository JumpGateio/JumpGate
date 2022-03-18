<?php

namespace App\Actions;

use JumpGate\Core\Services\Response;

class Destructive
{
    /**
     * @var
     */
    public $model;

    /**
     * @var string
     */
    public $status;

    /**
     * @var int
     */
    public $action;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    private $returnUrl;

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
     * @return \JumpGate\Core\Services\Response
     */
    public function execute()
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
    protected function determineMethod()
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
    protected function getMessage()
    {
        switch ($this->method) {
            default:
                return get_class($this->model) . ' ' . $this->method . 'd.';
        }
    }
}
