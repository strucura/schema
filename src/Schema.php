<?php

namespace Strucura\Schema;

use Strucura\Schema\Builders\BackedEnumSchemaBuilder;
use Strucura\Schema\Builders\ObjectSchemaBuilder;

class Schema
{
    public function object(string $type): ObjectSchemaBuilder
    {
        return app(ObjectSchemaBuilder::class, ['type' => $type]);
    }

    public function enum(string $backedEnumClass): BackedEnumSchemaBuilder
    {
        return app(BackedEnumSchemaBuilder::class, ['enumClass' => $backedEnumClass]);
    }
}
