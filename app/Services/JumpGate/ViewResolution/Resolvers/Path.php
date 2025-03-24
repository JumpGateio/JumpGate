<?php

namespace JumpGate\ViewResolution\Resolvers;

use Illuminate\Routing\Router;
use Illuminate\View\Factory;
use Illuminate\View\View;
use JumpGate\ViewResolution\Models\View as ViewModel;

class Path
{
    /**
     * @var \JumpGate\ViewResolution\Models\View
     */
    public $viewModel;

    /**
     * @var \JumpGate\ViewResolution\Resolvers\Path
     */
    public $path;

    /**
     * @var \JumpGate\ViewResolution\Resolvers\Layout|\Illuminate\View\View
     */
    public $layout;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $route;

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @param \Illuminate\Routing\Router $route
     * @param \Illuminate\View\Factory   $view
     */
    public function __construct(Router $route, Factory $view)
    {
        $this->route = $route;
        $this->view  = $view;
    }

    /**
     * Set up the needed details for the view.
     *
     * @param \Illuminate\View\View $layout
     * @param null|string           $view
     *
     * @return \Illuminate\View\View
     */
    public function setUp(View $layout, $view = null)
    {
        $this->layout = $layout;
        $this->setPath($view);
        $this->setContent();

        return $this->layout;
    }

    /**
     * Get a valid view path save it.
     *
     * @param $view
     */
    protected function setPath($view)
    {
        $this->viewModel = new ViewModel([], $this->layout->getName());

        if ($view == null) {
            $view = $this->findView();
        }

        $this->viewModel->view = $view;

        viewResolver()->collectDetails($this->viewModel);

        $this->path = $view;
    }

    /**
     * Put the found view inside the layout.
     */
    protected function setContent()
    {
        if (stripos($this->path, 'missingmethod') === false && $this->view->exists($this->path)) {
            try {
                $this->layout->content = $this->view->make($this->path);
            } catch (\Exception $e) {
                $this->layout->content = null;
            }
        }
    }

    /**
     * Try to figure out a view based on the called action.
     *
     * @param $layout
     * @param $parameters
     *
     * @return \Illuminate\View\View
     */
    public function missingMethod($layout, $parameters)
    {
        $view = $this->findView();

        if (count($parameters) == 1) {
            $view = str_ireplace('missingMethod', $parameters[0], $view);
        } elseif ($parameters[0] == null && $parameters[1] == null) {
            $view = str_ireplace('missingMethod', 'index', $view);
        } else {
            $view = implode('.', $parameters);
        }

        return $this->setUp($layout, $view);
    }

    /**
     * Find a view based on the available details.
     *
     * This will look in the config and the route details to
     * find a sensible place a view may be.
     *
     * @return string
     */
    protected function findView()
    {
        // Get the overall route name (SomeController@someMethod)
        // Break it up into it's component parts
        $route      = $this->route->currentRouteAction();
        $routeParts = explode('@', $route);

        if (count(array_filter($routeParts)) > 0) {
            $this->viewModel = new ViewModel($routeParts, $this->layout->getName());

            // Check for a configured view route.
            if (! is_null($configView = $this->viewModel->checkConfig())) {
                $this->viewModel->type = 'config';

                return $configView;
            }

            $this->viewModel->type = 'auto';

            return $this->viewModel->getView();
        }

        return null;
    }
}
