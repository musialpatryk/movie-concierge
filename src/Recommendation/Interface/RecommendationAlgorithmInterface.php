<?php

declare(strict_types=1);

namespace App\Recommendation\Interface;

interface RecommendationAlgorithmInterface
{
    public function getName(): string;

    /**
     * @param RecommendableInterface[] $recommendable
     * @return string[]
     */
    public function recommend(array $recommendable): array;
}
