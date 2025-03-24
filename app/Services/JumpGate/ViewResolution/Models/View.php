<?php

namespace App\Services\JumpGate\ViewResolution\Models;

use Illuminate\Support\Collection;
use ReflectionClass;

class View
{
    /**
     * @var null|string
     */
    public $layout = null;

    /**
     * @var null|string
     */
    public $fullController = null;

    /**
     * @var null|string
     */
    public $configIndex = null;

    /**
     * @var null|string
     */
    public $prefix = null;

    /**
     * @var null|string
     */
    public $controller = null;

    /**
     * @var null|string
     */
    public $action = null;

    /**
     * @var null|string
     */
    public $view = null;

    /**
     * @var string
     */
    public $type = 'manual';

    /**
     * @var Collection
     */
    public $prefixes;

    /**
     * @var Collection
     */
    public $attemptedViews;

    /**
     * @var bool
     */
    public $isInertiaFlag;

    /**
     * @param array $routeParts
     * @param null  $layout
     * @param bool  $isInertiaFlag
     */
    public function __construct(array $routeParts = [], $layout = null, $isInertiaFlag = false)
    {
        $this->attemptedViews = collect();
        $this->layout         = $layout;
        $this->isInertiaFlag  = $isInertiaFlag;

        if (! empty($routeParts)) {
            $this->parseController(head($routeParts));
            $this->parseAction(last($routeParts));
            $this->getPrefixes();
            $this->setView();
        }
    }

    /**
     * Find the most reasonable view available.
     *
     * @return null
     */
    public function getView()
    {
        // If we don't have a prefix, just return the view.
        if (is_null($this->prefix)) {
            return $this->getBaseView();
        }

        // Set up modifiable variables.
        $view     = $this->concatViewAndPrefix($this->prefix, $this->view);
        $prefixes = clone $this->prefixes;

        $this->attempted($view);

        // Try to find a valid view.
        while (! view()->exists($view)) {
            // If we are out of prefixes and the view still isn't found, back out.
            if (is_null($this->prefix) && ! view()->exists($view)) {
                $view = null;
                break;
            }

            // Remove prefixes until we don't have any left.
            if ($prefixes->count() > 0) {
                $prefixes->pop();

                $prefixes     = $this->removeControllerFromPrefixes($prefixes);
                $this->prefix = $prefixes->count() > 0 ? $prefixes->implode('.') : null;
                $view         = $this->concatViewAndPrefix($this->prefix, $this->view);
            } else {
                $this->prefix = null;
                $view         = $this->view;
            }

            $this->attempted($view);
        }

        $this->view = $view;

        return $this->view;
    }

    /**
     * Find the most reasonable component available.
     *
     * @return null
     */
    public function getComponent()
    {
        if (! is_null($this->view)) {

        }
        // If we don't have a prefix, just return the view.
        if (is_null($this->prefix)) {
            return $this->getBaseView();
        }

        $prefixes = clone $this->prefixes->transform(function ($data) {
            return ucfirst($data);
        });
        $this->prefix = $prefixes->implode($this->getConcatCharacter());

        // Set up modifiable variables.
        $view = $this->concatViewAndPrefix($this->prefix, $this->view);

        $this->attempted($view);

        // Try to find a valid view.
        while (! $this->exists($view)) {
            // If we are out of prefixes and the view still isn't found, back out.
            if (is_null($this->prefix) && ! $this->exists($view)) {
                $view = null;
                break;
            }

            // Remove prefixes until we don't have any left.
            if ($prefixes->count() > 0) {
                $prefixes->pop();

                $prefixes     = $this->removeControllerFromPrefixes($prefixes);
                $this->prefix = $prefixes->count() > 0 ? $prefixes->implode($this->getConcatCharacter()) : null;
                $view         = $this->concatViewAndPrefix($this->prefix, $this->view);
            } else {
                $this->prefix = null;
                $view         = $this->view;
            }

            $this->attempted($view);
        }

        $this->view = $view;

        return $this->view;
    }

    /**
     * When a view is checked, add it to attempted.
     *
     * @param string $view
     */
    protected function attempted($view)
    {
        $this->attemptedViews = $this->attemptedViews->push($view);
    }

    /**
     * Check if the file exists at the specific path.
     *
     * @param string $path
     *
     * @return bool
     */
    protected function exists($path)
    {
        if ($this->isInertiaFlag) {
            return file_exists(resource_path('js/Pages/' . $path . '.vue'));
        }

        return view()->exists($path);
    }

    /**
     * Combine a prefix and view to get a full path.
     *
     * @param string $prefix
     * @param string $view
     *
     * @return string
     */
    public function concatViewAndPrefix($prefix, $view)
    {
        if (is_null($prefix) || ! $prefix) {
            return $view;
        }

        return $prefix . $this->getConcatCharacter() . $view;
    }

    /**
     * Get a properly formatted controller name.
     *
     * @param string $class
     *
     * @return string
     */
    protected function parseController($class)
    {
        $controller           = new ReflectionClass($class);
        $this->fullController = $controller->name;
        $class                = $controller->getShortName();
        $this->controller     = strtolower(str_replace('Controller', '', $class));
    }

    /**
     * Get a properly formatted action name.
     *
     * @param string $action
     *
     * @return string
     */
    protected function parseAction($action)
    {
        if ($action === $this->fullController) {
            return $this->action = null;
        }

        $this->action = strtolower(
            preg_replace(['/^get/', '/^post/', '/^put/', '/^patch/', '/^delete/'], '', $action)
        );
    }

    /**
     * Search for any prefixes attached to this route.
     *
     * @return string
     */
    protected function getPrefixes()
    {
        $router = app(\Illuminate\Routing\Router::class);

        $this->prefixes = collect(
            explode('/', $router->getCurrentRoute()->getPrefix())
        );

        // Remove the last prefix if it matches the controller.
        $this->prefixes = $this->removeControllerFromPrefixes($this->prefixes)->filter();

        if ($this->prefixes->count() > 0) {
            $this->prefix = ucfirst($this->prefixes->filter()->implode($this->getConcatCharacter()));
        }
    }

    /**
     * Remove the last prefix if it matches the controller.
     *
     * @param \Illuminate\Support\Collection $prefixes
     *
     * @return mixed
     */
    protected function removeControllerFromPrefixes($prefixes)
    {
        if ($prefixes->last() == $this->controller) {
            $prefixes->pop();
        }

        return $prefixes;
    }

    /**
     * Combine the controller and action to create a proper view string.
     */
    protected function setView()
    {
        if ($this->isInertiaFlag) {
            $views = [
                ucfirst($this->controller),
                ucfirst($this->action),
            ];
        } else {
            $views = [
                $this->controller,
                $this->action,
            ];
        }

        $concat = $this->getConcatCharacter();

        $this->view = implode($concat, array_filter($views));
    }

    /**
     * Determine how we should concatenate the location
     * based on what view model we are using.
     *
     * @return string
     */
    protected function getConcatCharacter()
    {
        if ($this->isInertiaFlag) {
            return '/';
        }

        return '.';
    }

    /**
     * Return the base view if it exists.
     *
     * @return null|string
     */
    private function getBaseView()
    {
        $this->attempted($this->view);

        return $this->exists($this->view) ? $this->view : null;
    }

    /**
     * Check the view routing config for the controller and method.
     *
     * @return null|string
     */
    public function checkConfig()
    {
        $views = [
            $this->fullController,
            $this->action,
        ];

        $this->configIndex = implode('.', array_filter($views));

        return array_get(config('jumpgate.view-resolution.view_locations'), $this->configIndex);
    }
}
