<?php

namespace JumpGate\Core\Abstracts;

abstract class Transformer
{
    public static function transformAll($resources)
    {
        return supportCollector($resources)->map(function ($resource) {
            return get_called_class()::transform($resource);
        });
    }

    abstract public static function transform($resource);
}
