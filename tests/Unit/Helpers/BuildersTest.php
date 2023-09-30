<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\DataBuilderFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BuildersTest extends TestCase
{
    #[DataProvider('builderFormatProvider')]
    public function testBuilders(string $format): void
    {
        $builder = DataBuilderFactory::create($format);
        $builder->collectData($this->getBuilderFixture());
        $output = file_get_contents(__DIR__ . '/DataFixtures/' . $format . 'Output.txt');

        $this->assertSame(str_replace(["\r\n", "\r"], "\n", $output), $builder->getParsedData());
    }

    public static function builderFormatProvider(): array
    {
        return [
            ['csv'],
            ['xml']
        ];
    }

    private function getBuilderFixture(): array
    {
        return  [
            [
                'id' => 1,
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Test 1',
                'amount' => 12.05,
                'spent_at' => '2023-09-22 18:58:23',
                'info' => 'additional information',
                'category' => [
                    'name' => 'Clothes',
                    'category_id' => 1,
                ]
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Test 2',
                'amount' => 10.05,
                'spent_at' => '2023-09-23 18:58:23',
                'info' => 'additional information',
                'category' => [
                    'name' => 'Food',
                    'category_id' => 2,
                ]
            ]
        ];
    }
}
