<?php

namespace App\Tests\Recommendation;

use App\Recommendation\Interface\RecommendableInterface;

abstract class RecommendationTestUtil
{
    /**
     * @return RecommendableInterface[]
     */
    public static function getRecommendableFromTitles(string ...$titles): array
    {
        return array_map(
            static function(string $title): RecommendableInterface {
                return new class($title) implements RecommendableInterface {
                    public function __construct(private readonly string $title)
                    {
                    }

                    public function getTitle(): string
                    {
                        return $this->title;
                    }
                };
            },
            $titles
        );
    }
}
