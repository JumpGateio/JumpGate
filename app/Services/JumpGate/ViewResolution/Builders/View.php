<?php

namespace App\Services\JumpGate\ViewResolution\Builders;

use Illuminate\View\Factory;
use App\Services\JumpGate\ViewResolution\Models\View as ViewModel;
use App\Services\JumpGate\ViewResolution\Resolvers\Layout;
use App\Services\JumpGate\ViewResolution\Resolvers\Path;

class View
{
    /**
     * @var \Illuminate\View\View
     */
    public $layout;

    /**
     * @var Factory
     */
    public $view;

    /**
     * @var Layout
     */
    protected $viewLayout;

    /**
     * @var Path
     */
    protected $viewPath;

    /**
     * @param Layout  $viewLayout
     * @param Path    $viewPath
     * @param Factory $view
     */
    public function __construct(Layout $viewLayout, Path $viewPath, Factory $view)
    {
        $this->viewLayout = $viewLayout;
        $this->viewPath   = $viewPath;
        $this->view       = $view;
    }

    /**
     * @param array       $layoutOptions
     * @param null|string $view
     */
    public function setUp($layoutOptions, $view = null)
    {
        $this->layout         = $this->viewLayout->setUp($layoutOptions);
        $this->layout->layout = $this->viewPath->setUp($this->layout->layout, $view);
    }

    /**
     * Check if a view exists.
     *
     * @param string $view
     *
     * @return bool
     */
    public function exists($view)
    {
        return $this->view->exists($view);
    }

    /**
     * Get the current layout.
     *
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout->layout;
    }

    /**
     * If a method is not defined, try to find it's view.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function missingMethod($parameters)
    {
        if (! app()->runningInConsole()) {
            $this->viewPath->missingMethod($this->layout->layout, $parameters);
        }

        return $this;
    }

    /**
     * Set a custom layout for a page.
     *
     * @param string $view
     */
    public function setViewLayout($view)
    {
        $this->layout         = $this->viewLayout->change($view);
        $this->layout->layout = $this->viewPath->setUp($this->layout->layout, null);
    }

    /**
     * Override the automatically resolved view.
     *
     * @param string $view
     *
     * @return $this
     */
    public function setViewPath($view)
    {
        $this->layout->layout = $this->viewPath->setUp($this->layout->layout, $view);

        return $this;
    }

    /**
     * Share data with the view.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->view->share($key, $value);

        return $this;
    }

    /**
     * Return the dot notation view the resolver determined.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->viewPath->path;
    }

    /**
     * Return the details of the view resolution for troubleshooting.
     *
     * @return mixed
     */
    public function debug()
    {
        return $this->viewPath->viewModel;
    }

    /**
     * Pass the view resolution details to the debugbar collector.
     *
     * @param ViewModel $viewModel
     */
    public function collectDetails($viewModel)
    {
        if (checkDebugbar()) {
            $debugbar = app('debugbar');

            if ($debugbar->shouldCollect('auto_views')) {
                $debugbar['auto_views']->addDetails($viewModel);
            }
        }
    }
}
