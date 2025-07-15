<?php

namespace Strucura\Schema\Enums;

enum PropertyTypeEnum: string
{
    case PRIMITIVE = 'primitive';
    case ARRAY_OF = 'arrayOf';
    case ENUM = 'enum';
    case OBJECT = 'object';
    case REFERENCE = 'reference';
    case ANY_OF = 'anyOf';
}
