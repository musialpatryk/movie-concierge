<?php

declare(strict_types=1);

namespace App\Tests\Recommendation\Unit;

use App\Recommendation\Algorithm\RandomRecommendation;
use App\Recommendation\Interface\RecommendableInterface;
use App\Tests\Recommendation\RecommendationTestUtil;
use PHPUnit\Framework\TestCase;

class RandomRecommendationTest extends TestCase
{
    /**
     * @param RecommendableInterface[] $recommendable
     * @dataProvider algorithmDataProvider
     */
    public function testRecommendation(array $recommendable, int $expectedCount): void
    {
        $randomRecommendation = new RandomRecommendation();
        $initialRecommended = $randomRecommendation->recommend($recommendable);

        $this->assertCount($expectedCount, $initialRecommended);
    }

    public static function algorithmDataProvider(): array
    {
        return [
            'no recommendable in array' => [
                RecommendationTestUtil::getRecommendableFromTitles(),
                0
            ],
            'less recommendable count than searched count' => [
                RecommendationTestUtil::getRecommendableFromTitles('Test'),
                1
            ],
            'recommendable count same as searched count' => [
                RecommendationTestUtil::getRecommendableFromTitles('Test', 'Test2', 'Test3'),
                3
            ],
            'more recommendable count than searched count' => [
                RecommendationTestUtil::getRecommendableFromTitles('Test', 'Test2', 'Test3', 'Test4'),
                3
            ],
        ];
    }
}
