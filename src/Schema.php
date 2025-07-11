<?php

namespace Strucura\Schema;

use BackedEnum;
use Strucura\Schema\Builders\EnumSchemaBuilder;
use Strucura\Schema\Builders\ObjectSchemaBuilder;

class Schema
{
    public function object(): ObjectSchemaBuilder
    {
        return app(ObjectSchemaBuilder::class);
    }

    public function enum(): EnumSchemaBuilder
    {
        return app(EnumSchemaBuilder::class);
    }
}
