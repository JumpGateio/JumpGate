<?php

namespace App\Services\JumpGate\ViewResolution\Collectors;

use DebugBar\Bridge\Twig\TwigCollector;
use DebugBar\DataCollector\Renderable;
use App\Services\JumpGate\ViewResolution\Models\View as ViewModel;

class AutoViewCollector extends TwigCollector implements Renderable
{
    /**
     * @var null|ViewModel\
     */
    public $viewModel = null;

    /**
     * Create a ViewCollector
     */
    public function __construct()
    {
        $this->name = 'auto_views';
    }

    public function getName()
    {
        return 'auto_views';
    }

    public function getWidgets()
    {
        return [
            'auto_resolved_view' => [
                'icon'    => 'archive',
                'widget'  => 'PhpDebugBar.Widgets.VariableListWidget',
                'map'     => 'auto_views',
                'default' => '{}',
            ],
        ];
    }

    public function addDetails(ViewModel $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    public function collect()
    {
        // If the app is not using the auto resolved views, redirect them to something helpful.
        if ($this->viewModel === null) {
            return [
                'Details' => 'Using inertia.  Nothing to auto-resolve.  Look to the inertia tab in debugbar or enable it
                in the configs to get inertia details.',
            ];
        }

        $attemptedViews = $this->viewModel->attemptedViews;
        $prefixes       = $this->viewModel->prefixes;

        $data = [
            'resolved view'     => $this->viewModel->view,
            'resolution type'   => $this->viewModel->type,
            'attempted views'   => $this->getDataFormatter()
                                        ->formatVar($attemptedViews ? $attemptedViews->toArray() : $attemptedViews),
            'controller'        => $this->viewModel->controller,
            'action'            => is_null($this->viewModel->action) ? 'null (__invoke)' : $this->viewModel->action,
            'final prefix'      => $this->viewModel->prefix,
            'possible prefixes' => $this->getDataFormatter()
                                        ->formatVar($prefixes ? $prefixes->toArray() : $prefixes),
            'config index'      => $this->viewModel->configIndex,
            'is inertia'        => $this->viewModel->isInertiaFlag,
        ];

        return $data;
    }
}
