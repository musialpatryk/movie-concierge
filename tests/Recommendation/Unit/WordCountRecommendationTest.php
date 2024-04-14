<?php

declare(strict_types=1);

namespace App\Tests\Recommendation\Unit;

use App\Recommendation\Algorithm\WordCountRecommendation;
use App\Recommendation\Interface\RecommendableInterface;
use App\Tests\Recommendation\RecommendationTestUtil;
use PHPUnit\Framework\TestCase;

class WordCountRecommendationTest extends TestCase
{
    /**
     * @param RecommendableInterface[] $recommendable
     * @dataProvider algorithmDataProvider
     */
    public function testRecommendation(array $recommendable, int $expectedCount): void
    {
        $recommended = (new WordCountRecommendation())->recommend($recommendable);

        $this->assertCount($expectedCount, $recommended);
    }

    public static function algorithmDataProvider(): array
    {
        return [
            'no recommendable' => [
                RecommendationTestUtil::getRecommendableFromTitles(),
                0
            ],
            'only single word recommendable' => [
                RecommendationTestUtil::getRecommendableFromTitles('Word1', 'Word2'),
                0
            ],
            'only more than one word recommendable' => [
                RecommendationTestUtil::getRecommendableFromTitles('Word1 Word2', 'Word3 Word4'),
                2
            ],
            'mixed word count in recommendable' => [
                RecommendationTestUtil::getRecommendableFromTitles(
                    'Word1 Word2',
                    'Word3 Word4',
                    'Word4 Word5-Word6',
                    'Skipped',
                    ''
                ),
                3
            ],
            'one word, ending with space in recommendable' => [
                RecommendationTestUtil::getRecommendableFromTitles(
                    'Skipped ',
                ),
                0
            ],
        ];
    }
}
