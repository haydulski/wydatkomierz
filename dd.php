<?php

declare(strict_types=1);

class Book
{
    private array $properties;

    public function __construct(array $config)
    {
        $this->initiate($config);
    }

    private function initiate(array $data)
    {
        if (count($data) === 0) {
            return;
        }

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst(strtolower($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    private function setName(string $value): void
    {
        $this->properties['name'] = $value;
    }

    public function getName(): string
    {
        return $this->properties['name'] ?? 'no data';
    }
}

$dumyData = [
    'title' => 'W pustyni',
    'name' => 'Henryk'
];

$book = new Book($dumyData);

echo $book->getName();
