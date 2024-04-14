<?php

declare(strict_types=1);

namespace App\Tests\Recommendation\Unit;

use App\Recommendation\Algorithm\CharacterRulesRecommendation;
use App\Recommendation\Interface\RecommendableInterface;
use App\Tests\Recommendation\RecommendationTestUtil;
use PHPUnit\Framework\TestCase;

class CharacterRulesRecommendationTest extends TestCase
{
    /**
     * @param RecommendableInterface[] $recommendable
     * @dataProvider algorithmDataProvider
     */
    public function testRecommendation(array $recommendable, int $expectedCount): void
    {
        $recommended = (new CharacterRulesRecommendation())->recommend($recommendable);

        $this->assertCount($expectedCount, $recommended);
    }

    public static function algorithmDataProvider(): array
    {
        return [
            'even char count and starting with \'W\' ' => [
                RecommendationTestUtil::getRecommendableFromTitles('W_', 'W___', 'W_____'),
                3
            ],
            'even char count and not starting with \'W\' ' => [
                RecommendationTestUtil::getRecommendableFromTitles('A_', 'B___', 'C_____'),
                0
            ],
            'not even char count and not starting with \'W\' ' => [
                RecommendationTestUtil::getRecommendableFromTitles('A__', 'B____', 'C______'),
                0
            ],
            'not even char count and starting with \'W\' ' => [
                RecommendationTestUtil::getRecommendableFromTitles('W__', 'W____', 'W______'),
                0
            ],
            'with one even char count and starting with \'W\' ' => [
                RecommendationTestUtil::getRecommendableFromTitles('A__', 'B____', 'C______', 'W_'),
                1
            ],
        ];
    }
}
