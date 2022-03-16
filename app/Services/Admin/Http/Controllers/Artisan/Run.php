<?php

namespace App\Services\Admin\Http\Controllers\Artisan;

use App\Services\Admin\Http\Controllers\Base;
use Symfony\Component\Process\Process;

class Run extends Base
{
    public function __invoke()
    {
        try {
            $artisanCommand = $this->buildCommand();
            $commands       = ['cd ../', $artisanCommand];

            $process = Process::fromShellCommandline(implode(' && ', $commands));
            $process->run();

            $result = $process->getOutput();

            return response()->json($result);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getLine()], 500);
        }
    }

    protected function buildCommand()
    {
        $command = json_decode(json_encode(request('command')));
        $result  = supportCollector([
            './artisan',
            $command->name,
        ]);

        if (! isset($command->passables)) {
            return $result->implode(' ');
        }

        supportCollector($command->passables)
            ->map(function ($passable) use (&$result) {
                if ($passable->type == 'flag' && ! $passable->value) {
                    return null;
                }

                if ($passable->type === 'flag') {
                    return $result->push('--' . $passable->name);
                }

                if ($passable->mode === 'option' && is_array($passable->value) && empty($passable->value)) {
                    return null;
                }

                if ($passable->mode === 'option' && is_array($passable->value) && ! empty($passable->value)) {
                    return $result->push('--' . $passable->name . '=' . implode(',', $passable->value));
                }

                if ($passable->mode === 'option' && ! is_null($passable->value)) {
                    return $result->push('--' . $passable->name . '=' . $passable->value);
                }

                if ($passable->mode === 'argument' && ! is_null($passable->value)) {
                    return $result->push($passable->value);
                }
            })
            ->filter();

        return $result->implode(' ');
    }
}
