<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Abstracts\FileBuilderAbstract;
use DateTime;
use SimpleXMLElement;

class XmlFileBuilder extends FileBuilderAbstract
{
    public function collectData(array $data): void
    {
        $this->rawData = $data;
        $this->parseData();
    }

    public function getFileFormat(): string
    {
        return 'xml';
    }

    protected function parseData(): void
    {
        $xml = new SimpleXMLElement('<body></body>');
        $expenses = $xml->addChild('expenses');
        $sum = 0;

        foreach ($this->rawData as $node) {
            $expense = $expenses->addChild('expense');
            $expense->addAttribute('id', (string) $node['id']);
            $expense->addAttribute('user_id', (string) $node['user_id']);
            $expense->addAttribute('category_id', (string)  $node['category_id']);
            $expense->addChild('title', $node['title']);
            $expense->addChild('amount', (string)  $node['amount']);
            $expense->addChild('date', (new DateTime($node['spent_at']))->format('Y-m-d H:i:s'));
            $expense->addChild('description', $node['info']);
            $expense->addChild('title', $node['title']);
            $expense->addChild('category_name', $node['category']['name']);
            $sum += (float) $node['amount'];
        }
        $xml->addChild('total_amount', (string) $sum);

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        $this->parsedData = $dom->saveXML();
    }
}
