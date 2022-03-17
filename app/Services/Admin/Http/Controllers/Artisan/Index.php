<?php

namespace App\Services\Admin\Http\Controllers\Artisan;

use App\Services\Admin\Http\Controllers\Base;
use Illuminate\Support\Facades\Artisan as ArtisanFacade;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Index extends Base
{
    public function __invoke()
    {
        $title = 'Artisan Commands';
        $commands = supportCollector(ArtisanFacade::all())
            ->map(function ($command) {
                $details = [
                    'name'        => $command->getName(),
                    'description' => $command->getDescription(),
                ];

                if (is_null($definition = $command->getDefinition())) {
                    return (object)$details;
                }

                $arguments = $definition->getArguments();
                $options   = $definition->getOptions();

                if ($arguments || $options) {
                    $details['passables'] = [];
                }

                foreach ($arguments as $argument) {
                    $argumentDetails = (object)[
                        'mode'        => 'argument',
                        'name'        => $argument->getName(),
                        'display'     => ucwords($argument->getName()),
                        'value'       => $argument->getDefault(),
                        'description' => $argument->getDescription(),
                        'type'        => $this->getArgumentLevel($argument),
                    ];

                    $details['passables'][] = $argumentDetails;
                }

                foreach ($options as $option) {
                    $optionDetails = (object)[
                        'mode'        => 'option',
                        'name'        => $option->getName(),
                        'display'     => ucwords($option->getName()),
                        'value'       => $option->getDefault(),
                        'description' => $option->getDescription(),
                        'type'        => $this->getOptionLevel($option),
                    ];

                    $details['passables'][] = $optionDetails;
                }

                return $details;
            })
            ->sortBy('name');

        return $this->response(
            compact('title', 'commands'),
            'Admin/Artisan/Index'
        );
    }

    protected function getArgumentLevel(InputArgument $argument)
    {
        if ($argument->isRequired()) {
            return 'required';
        }

        if ($argument->isArray()) {
            return 'array';
        }

        return 'optional';
    }

    protected function getOptionLevel(InputOption $option)
    {
        if ($option->isValueRequired()) {
            return 'required';
        }

        if ($option->isArray()) {
            return 'array';
        }

        if ($option->isValueOptional()) {
            return 'optional';
        }

        return 'flag';
    }
}
