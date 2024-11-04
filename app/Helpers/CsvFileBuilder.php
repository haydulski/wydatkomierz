<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Abstracts\FileBuilderAbstract;
use DateTime;

class CsvFileBuilder extends FileBuilderAbstract
{
    public function collectData(array $data): void
    {
        $this->rawData = $data;
        $this->parseData();
    }

    public function getFileFormat(): string
    {
        return 'csv';
    }

    protected function parseData(): void
    {
        $rawCsv = [];
        $rawCsv[] = ['id', 'user_id', 'category_id', 'category_name', 'title', 'amount', 'date', 'is_common'];
        foreach ($this->rawData as $node) {
            $rawCsv[] = [
                $node['id'],
                $node['user_id'],
                $node['category_id'],
                $node['category']['name'],
                $node['title'],
                $node['amount'],
                (new DateTime($node['spent_at']))->format('Y-m-d H:i:s'),
                $node['is_common'],
            ];
        }

        $aggregator = '';
        foreach ($rawCsv as $row) {
            $aggregator .= implode(';', $row) . "\n";
        }

        $this->parsedData = $aggregator;
    }
}
