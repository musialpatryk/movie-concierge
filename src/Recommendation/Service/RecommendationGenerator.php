<?php

declare(strict_types=1);

namespace App\Recommendation\Service;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendableProviderInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class RecommendationGenerator {
    /**
     * @var RecommendationAlgorithmInterface[]
     */
    private array $recommendationAlgorithms;

    public function __construct(
        #[TaggedIterator('app.recommendation.recommendation_algorithm')] iterable $recommendationAlgorithms,
        private RecommendableProviderInterface $recommendableProvider,
    ) {
        $this->recommendationAlgorithms = [...$recommendationAlgorithms];
    }

    /**
     * @return RecommendableInterface[]|null
     */
    public function generate(string $algorithmName): ?array {
        $algorithm = $this->getAlgorithmByName($algorithmName);

        return $algorithm?->recommend(
            $this->recommendableProvider->getAll()
        );

    }

    private function getAlgorithmByName(string $name): RecommendationAlgorithmInterface|null {
        foreach ($this->recommendationAlgorithms as $recommendationAlgorithm) {
            if ($recommendationAlgorithm->getName() === $name) {
                return $recommendationAlgorithm;
            }
        }

        return null;
    }

    /**
     * @return string[]
     */
    public function getAlgorithmNames(): array
    {
        return array_map(
            static fn (RecommendationAlgorithmInterface $algorithm): string => $algorithm->getName(),
            $this->recommendationAlgorithms
        );
    }
}
