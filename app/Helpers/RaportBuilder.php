<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;

class RaportBuilder
{

    private SimpleXMLElement $xml;

    public function __construct(private Collection $rawData)
    {
        $this->parseData();
    }

    public function getXml(): string
    {
        $dom = dom_import_simplexml($this->xml)->ownerDocument;
        $dom->formatOutput = true;

        // Get the formatted XML content
        $formattedXml = $dom->saveXML();

        return $formattedXml;
    }

    private function parseData(): void
    {
        $xml = new SimpleXMLElement('<body></body>');
        $expenses = $xml->addChild('expenses');

        foreach ($this->rawData as $node) {
            $expense = $expenses->addChild('expense');
            $expense->addAttribute('id', (string) $node->id);
            $expense->addAttribute('user_id', (string) $node->user_id);
            $expense->addAttribute('category_id', (string)  $node->category_id);
            $expense->addChild('title', $node->title);
            $expense->addChild('amount', (string)  $node->amount);
            $expense->addChild('date', $node->spent_at->format('Y-m-d H:i:s'));
            $expense->addChild('description', $node->info);
            $expense->addChild('title', $node->title);
            $expense->addChild('category_name', $node->category->name);
        }

        $this->xml = $xml;
    }
}
