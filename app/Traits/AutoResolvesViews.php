<?php

namespace App\Traits;

use Inertia\ResponseFactory;

trait AutoResolvesViews
{
    /**
     * @var null|\Illuminate\View\View
     */
    protected $layout;

    /**
     * Find the view for the called method.
     *
     * @param null|string $view
     * @param null|string $layout
     *
     * @return $this
     */
    public function view($view = null, $layout = null)
    {
        $layoutOptions = $this->getLayoutOptions($layout);

        // Set up the default view resolution
        viewResolver()->setUp($layoutOptions, $view);
        $this->setupLayout();
    }

    /**
     * Find the component for an inertia response.
     *
     * @param array       $data
     * @param null|string $page
     *
     * @return \Inertia\Response
     */
    public function inertia($data = [], $page = null)
    {
        $viewModel = inertiaResolver()->setUp($page);

        return app(ResponseFactory::class)->render($viewModel->view, $data);
    }

    /**
     * Get an array of layout options if available.
     *
     * @param null|string $layout
     *
     * @return array|null
     */
    protected function getLayoutOptions($layout)
    {
        // If passed a layout, use that for any request.
        if (! is_null($layout)) {
            return [
                'default' => $layout,
                'ajax'    => $layout,
            ];
        }

        // If a set of layout options is defined, use those.
        if (isset($this->layoutOptions)) {
            return $this->layoutOptions;
        }

        // Use nothing.
        return null;
    }

    /**
     * Force the layout for the view.
     *
     * @param string $layout
     */
    public function setViewLayout($layout)
    {
        $this->layoutOptions = [
            'default' => $layout,
            'ajax'    => $layout,
        ];;
    }

    /**
     * Master template method
     * Sets the template based on location and passes variables to the view.
     *
     * @return void
     */
    public function setupLayout()
    {
        $this->layout = viewResolver()->getLayout();
    }

    /**
     * Execute an action on the controller.
     *
     * Overloading this method to make sure our layout is
     * always used.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = call_user_func_array([$this, $method], $parameters);

        if (is_null($response) && ! is_null($this->layout)) {
            $response = $this->layout;
        }

        return $response;
    }

    /**
     * Catch a missing method and try to figure out what
     * it should be.
     *
     * @param array $parameters
     *
     * @return mixed|void
     */
    public function missingMethod($parameters = [])
    {
        viewResolver()->missingMethod($parameters);
    }

    /**
     * Catch any un-found method and route through
     * missing method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed|void
     */
    public function __call($method, $parameters)
    {
        $parameters = array_merge((array)$method, $parameters);

        return $this->missingMethod($parameters);
    }
}
