<?php

namespace App\Services\ViewResolution\Builders;

use Illuminate\Filesystem\Filesystem;
use Inertia\ResponseFactory;
use App\Services\ViewResolution\Models\View as ViewModel;
use App\Services\ViewResolution\Resolvers\Inertia as InertiaResolver;

class Inertia
{
    public InertiaResolver $resolver;

    public Filesystem      $files;

    /**
     * @param InertiaResolver $resolver
     * @param Filesystem      $files
     */
    public function __construct(InertiaResolver $resolver, Filesystem $files)
    {
        $this->resolver = $resolver;
        $this->files    = $files;
    }

    /**
     * @param null|string $page
     *
     * @return ViewModel
     */
    public function setUp(?string $page = null): ViewModel
    {
        return $this->resolver->setUp($page);
    }

    /**
     * Check if a component file exists.
     *
     * @param string $view
     *
     * @return bool
     */
    public function exists(string $view): bool
    {
        return $this->files->exists(resource_path('js/Pages/' . $view));
    }

    /**
     * Share data with the view.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addData($key, $value): self
    {
        app(ResponseFactory::class)->share($key, $value);

        return $this;
    }

    /**
     * Return the dot notation view the resolver determined.
     *
     * @return mixed
     */
    public function getPath(): mixed
    {
        return $this->viewPath->path;
    }

    /**
     * Return the details of the view resolution for troubleshooting.
     *
     * @return mixed
     */
    public function debug(): mixed
    {
        return $this->viewPath->viewModel;
    }

    /**
     * Pass the view resolution details to the debugbar collector.
     *
     * @param ViewModel $viewModel
     */
    public function collectDetails(ViewModel $viewModel): void
    {
        if (checkDebugbar()) {
            $debugbar = app('debugbar');

            if ($debugbar->shouldCollect('auto_views')) {
                $debugbar['auto_views']->addDetails($viewModel);
            }
        }
    }
}
