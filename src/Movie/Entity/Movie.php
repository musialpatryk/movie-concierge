<?php

declare(strict_types=1);

namespace App\Movie\Entity;

use App\Recommendation\Interface\RecommendableInterface;

readonly class Movie implements RecommendableInterface
{
    public function __construct(private string $title)
    {
    }

    public function getTitle() : string {
        return $this->title;
    }
}
