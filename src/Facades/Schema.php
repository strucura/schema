<?php

namespace Strucura\Schema\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Strucura\Schema\Schema
 */
class Schema extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Strucura\Schema\Schema::class;
    }
}
