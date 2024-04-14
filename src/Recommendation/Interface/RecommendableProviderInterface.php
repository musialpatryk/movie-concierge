<?php

namespace App\Recommendation\Interface;


interface RecommendableProviderInterface
{
    /**
     * @return RecommendableInterface[]
     */
    public function getAll(): array;
}
