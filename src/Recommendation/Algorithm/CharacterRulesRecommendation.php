<?php

namespace App\Recommendation\Algorithm;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Interface\RecommendationAlgorithmInterface;

class CharacterRulesRecommendation implements RecommendationAlgorithmInterface
{
    private const FIRST_CHAR = 'W';
    private const CHAR_SHOULD_BE_EVEN = true;

    public function getName(): string
    {
        return 'character_rules_recommendation';
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
                $title = $recommendable->getTitle();

                return str_starts_with($title, self::FIRST_CHAR)
                    && (
                        self::CHAR_SHOULD_BE_EVEN && strlen($title) % 2 === 0
                        || !self::CHAR_SHOULD_BE_EVEN && strlen($title) % 2 !== 0
                    );
            }
        );

        return array_values($recommendedItems);
    }
}
