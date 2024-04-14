<?php

declare(strict_types=1);

namespace App\Tests\Recommendation\Unit;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendableProviderInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;
use App\Recommendation\Service\RecommendationGenerator;
use App\Tests\Recommendation\RecommendationTestUtil;
use PHPUnit\Framework\TestCase;

class RecommendationGeneratorTest extends TestCase
{
    private int $algorithmsCount = 0;

    public function testUseCorrectAlgorithm(): void
    {
        $recommendable = RecommendationTestUtil::getRecommendableFromTitles('Test');

        $recommendationGenerator = new RecommendationGenerator(
            [
                $this->getRecommendationAlgorithmStub($recommendable),
                $this->getRecommendationAlgorithmStub($recommendable),
                $this->getRecommendationAlgorithmStub($recommendable),
            ],
            $this->getRecommendableProviderStub($recommendable)
        );

        $noAlgorithm = $recommendationGenerator->generate('no_algorithm');
        $this->assertNull($noAlgorithm);

        $allRecommendable = $recommendationGenerator->generate('algorithm_0');
        $this->assertCount(count($recommendable), $allRecommendable);

        $emptyRecommendable = $recommendationGenerator->generate('algorithm_1');
        $this->assertCount(0, $emptyRecommendable);
    }

    /**
     * @param RecommendableInterface[] $recommendable
     */
    private function getRecommendationAlgorithmStub(array $recommendable): RecommendationAlgorithmInterface
    {
        $recommendationAlgorithmStub = $this->createStub(RecommendationAlgorithmInterface::class);

        $recommendationAlgorithmStub->method('getName')
            ->willReturn('algorithm_'.$this->algorithmsCount);

        $recommendationAlgorithmStub->method('recommend')
            ->willReturn($this->algorithmsCount % 2 === 0 ? $recommendable : []);

        $this->algorithmsCount++;

        return $recommendationAlgorithmStub;
    }

    /**
     * @param RecommendableInterface[] $recommendable
     */
    private function getRecommendableProviderStub(array $recommendable): RecommendableProviderInterface
    {
        $recommendableProviderStub = $this->createStub(RecommendableProviderInterface::class);

        $recommendableProviderStub->method('getAll')
            ->willReturn($recommendable);

        return $recommendableProviderStub;
    }
}
