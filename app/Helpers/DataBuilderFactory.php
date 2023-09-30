<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Contracts\DataBuilderInterface;
use App\Abstracts\FileBuilderAbstract;
use Exception;

class DataBuilderFactory implements DataBuilderInterface
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
