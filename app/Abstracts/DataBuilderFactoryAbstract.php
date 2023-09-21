<?php

declare(strict_types=1);

namespace App\Abstracts;

abstract class DataBuilderFactoryAbstract
{
    abstract public static function create(string $type): FileBuilderAbstract;
}
