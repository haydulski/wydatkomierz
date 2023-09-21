<?php

declare(strict_types=1);

namespace App\Abstracts;

abstract class FileBuilderAbstract
{
    protected string $parsedData;
    protected array $rawData;

    abstract public function collectData(array $data): void;

    abstract public function getFileFormat(): string;

    abstract protected function parseData(): void;

    public function getParsedData(): string
    {
        return $this->parsedData;
    }
}
