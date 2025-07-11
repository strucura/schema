<?php

namespace Strucura\Schema;

use Strucura\Schema\Builders\BackedEnumSchemaBuilder;
use Strucura\Schema\Builders\ObjectSchemaBuilder;

class Schema
{
    public function object(): ObjectSchemaBuilder
    {
        return app(ObjectSchemaBuilder::class);
    }

    public function enum(string $backedEnumClass): BackedEnumSchemaBuilder
    {
        return app(BackedEnumSchemaBuilder::class, ['enumClass' => $backedEnumClass]);
    }
}
