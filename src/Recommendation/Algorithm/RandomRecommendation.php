<?php

namespace App\Recommendation\Algorithm;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;

class RandomRecommendation implements RecommendationAlgorithmInterface
{
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
        // TODO: Implement recommend() method.
    }
}
