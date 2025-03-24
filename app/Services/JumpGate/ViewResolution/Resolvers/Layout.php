<?php

namespace JumpGate\ViewResolution\Resolvers;

use Illuminate\Config\Repository;
use Illuminate\View\Factory;
use Illuminate\Http\Request;

class Layout
{
    /**
     * @var \Illuminate\View\View
     */
    public $layout;

    /**
     * @var \Illuminate\View\View
     */
    protected $view;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $layoutOptions;

    /**
     * @param \Illuminate\View\Factory      $view
     * @param \Illuminate\Http\Request      $request
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Factory $view, Request $request, Repository $config)
    {
        $this->view    = $view;
        $this->request = $request;
        $this->config  = $config;
    }

    /**
     * Set up the initial layout to be used.
     *
     * @param $layoutOptions
     *
     * @return $this
     */
    public function setUp($layoutOptions)
    {
        $this->layoutOptions = $this->verifyLayoutOptions($layoutOptions);
        $this->layout        = $this->determineLayout(null);
        $this->setPageTitle();
        $this->layout->content = null;

        return $this;
    }

    /**
     * Change the selected layout to something else and ready it for content.
     *
     * @param $view
     *
     * @return $this
     */
    public function change($view)
    {
        $this->layout = $this->determineLayout($view);
        $this->setPageTitle();
        $this->layout->content = null;

        return $this;
    }

    /**
     * Auto determine a logic page title.
     */
    public function setPageTitle()
    {
        $area     = $this->request->segment(1);
        $location = ($this->request->segment(2) != null ? ': ' . ucwords($this->request->segment(2)) : '');

        if ($area != null) {
            $pageTitle = ucwords($area) . $location;
        } else {
            $pageTitle = $this->config->get('core::siteName') . ($this->request->segment(1) != null ? ': ' . ucwords($this->request->segment(1)) : '');
        }

        $this->view->share('pageTitle', $pageTitle);
    }

    /**
     * Determine which layout to use based on the request.
     *
     * @param $layout
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function determineLayout($layout)
    {
        if (! is_null($layout)) {
            return $this->view->make($layout);
        }

        if (is_string($this->layout)) {
            return $this->view->make($this->layout);
        }

        if (is_null($this->layout) && $this->request->ajax()) {
            return $this->view->make($this->layoutOptions['ajax']);
        }

        if (is_null($this->layout)) {
            return $this->view->make($this->layoutOptions['default']);
        }

        return $this->layout;
    }

    /**
     * Make sure that we have a valid set of layout options.
     *
     * @param $layoutOptions
     *
     * @return mixed
     */
    private function verifyLayoutOptions($layoutOptions)
    {
        // If using the config details, go with that instead of expecting passed options.
        if (config('jumpgate.view-resolution.load_layout')) {
            return config('jumpgate.view-resolution.layout_options');
        }

        // If using the passed options, make sure they are valid options.
        if (! is_array($layoutOptions)) {
            throw new \InvalidArgumentException('The layoutOptions must be an array.');
        }
        if (! isset($layoutOptions['default'])) {
            throw new \InvalidArgumentException('The layoutOptions must have a default layout view.');
        }
        if (! isset($layoutOptions['ajax'])) {
            throw new \InvalidArgumentException('The layoutOptions must have a ajax layout view.');
        }

        return $layoutOptions;
    }
}
