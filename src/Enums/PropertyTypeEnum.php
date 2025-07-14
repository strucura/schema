<?php

namespace Strucura\Schema\Enums;

enum PropertyTypeEnum: string
{
    case STRING = 'string';
    case INTEGER = 'integer';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case FLOAT = 'float';
    case BYTE = 'byte';
    case BINARY = 'binary';
    case DECIMAL = 'decimal';
    case ARRAY = 'array';
    case ENUM = 'enum';
    case OBJECT = 'object';
    case REFERENCE = 'reference';
    case ANY_OF = 'anyOf';
}
