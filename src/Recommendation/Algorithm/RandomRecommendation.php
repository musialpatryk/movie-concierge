<?php

namespace App\Recommendation\Algorithm;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;

class RandomRecommendation implements RecommendationAlgorithmInterface
{
    private const RANDOM_RECOMMENDATIONS_COUNT = 3;

    public function getName(): string
    {
        return 'random_recommendation';
    }

    /**
     * @param RecommendableInterface[] $recommendable
     * @return string[]
     */
    public function recommend(array $recommendable): array
    {
        $randomKeys = array_rand($recommendable, self::RANDOM_RECOMMENDATIONS_COUNT);

        $randomRecommendable = [];
        foreach ($randomKeys as $key) {
            $randomRecommendable[] = $recommendable[$key];
        }

        return $randomRecommendable;
    }
}
