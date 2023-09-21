<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Abstracts\DataBuilderFactoryAbstract;
use App\Abstracts\FileBuilderAbstract;
use Exception;

class DataBuilderFactory extends DataBuilderFactoryAbstract
{
    public static function create(string $type): FileBuilderAbstract
    {
        $parserClass = 'App\\Helpers\\' . ucfirst($type) . 'FileBuilder';

        if (class_exists($parserClass)) {
            return new $parserClass();
        }

        throw new Exception($parserClass . ' class not exists.');
    }
}
