<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Abstracts\FileBuilderAbstract;

interface DataBuilderInterface
{
    public static function create(string $type): FileBuilderAbstract;
}
