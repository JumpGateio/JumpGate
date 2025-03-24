<?php

namespace App\Services\JumpGate\ViewResolution\Resolvers;

use Illuminate\Routing\Router;
use App\Services\JumpGate\Core\Collections\SupportCollection;
use App\Services\JumpGate\ViewResolution\Models\View;

class Inertia
{
    public Router $route;

    public View $viewModel;

    public string $path;

    public function __construct(Router $route)
    {
        $this->route = $route;
    }

    /**
     * Set up the needed details for the view.
     *
     * @param null|string $page
     *
     * @return View
     */
    public function setUp(?string $page = null): View
    {
        $this->setPath($page);

        return $this->viewModel;
    }

    /**
     * Get a valid view path save it.
     *
     * @param $view
     */
    protected function setPath($view): void
    {
        $this->viewModel = new View([], null, true);

        if ($view == null) {
            $view = $this->findView();
        }

        if (str_contains($view, '.')) {
            $view = SupportCollection::explode('.', $view)
                ->transform(function ($part) {
                    return ucfirst($part);
                })
                ->implode('/');
        }

        $this->viewModel->view = $view;

        inertiaResolver()->collectDetails($this->viewModel);

        $this->path = $view;
    }

    /**
     * Find a view based on the available details.
     *
     * This will look in the config and the route details to
     * find a sensible place a view may be.
     *
     * @return ?string
     */
    protected function findView(): ?string
    {
        // Get the overall route name (SomeController@someMethod)
        // Break it up into it's component parts
        $route      = $this->route->currentRouteAction();
        $routeParts = explode('@', $route);

        if (count(array_filter($routeParts)) > 0) {
            $this->viewModel = new View($routeParts, null, true);

            // Check for a configured view route.
            if (! is_null($configView = $this->viewModel->checkConfig())) {
                $this->viewModel->type = 'config';

                return $configView;
            }

            $this->viewModel->type = 'auto';

            return $this->viewModel->getComponent();
        }

        return null;
    }
}
