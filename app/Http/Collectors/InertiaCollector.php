<?php

namespace App\Http\Collectors;

use DebugBar\Bridge\Twig\TwigCollector;
use DebugBar\DataCollector\Renderable;
use Inertia\Inertia;

class InertiaCollector extends TwigCollector implements Renderable
{
    /**
     * @var null|string
     */
    public $page = null;

    /**
     * @var array
     */
    public $data = [];

    /**
     * Create a ViewCollector
     */
    public function __construct()
    {
        $this->name = 'inertia';
    }

    public function getName()
    {
        return 'inertia';
    }

    public function getWidgets()
    {
        return [
            'inertia' => [
                'icon'    => 'archive',
                'widget'  => 'PhpDebugBar.Widgets.VariableListWidget',
                'map'     => 'inertia',
                'default' => '{}',
            ],
        ];
    }

    public function addDetails($page, $data)
    {
        $this->page = $page;
        $this->data = $data;
    }

    public function collect()
    {
        $shared = Inertia::getShared();

        $data = [
            'Loaded Component' => $this->page,
            'Page Data'        => $this->getDataFormatter()
                ->formatVar($this->data ? (array)$this->data : $this->data),
            'Global Data' => $this->getDataFormatter()
                ->formatVar($shared ? (array)$shared : $shared),
        ];

        return $data;
    }
}
