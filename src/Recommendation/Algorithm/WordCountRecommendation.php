<?php

namespace App\Recommendation\Algorithm;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;

class WordCountRecommendation implements RecommendationAlgorithmInterface
{
    private const MIN_WORD_COUNT = 2;

    public function getName(): string
    {
        return 'word_count_recommendation';
    }

    /**
     * @param RecommendableInterface[] $recommendable
     * @return string[]
     */
    public function recommend(array $recommendable): array
    {
        $recommendedItems = array_filter(
            $recommendable,
            static function (RecommendableInterface $recommendable): bool {
                return str_word_count($recommendable->getTitle()) >= self::MIN_WORD_COUNT;
            }
        );

        return array_values($recommendedItems);
    }
}
