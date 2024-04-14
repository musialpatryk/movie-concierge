<?php

declare(strict_types=1);

namespace App\Recommendation\Controller;

use App\Recommendation\Interface\RecommendableInterface;
use App\Recommendation\Service\RecommendationGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class RecommendationController extends AbstractController
{
    public function __construct(private readonly RecommendationGenerator $recommendationGenerator)
    {
    }

    #[Route('/api/recommendations', name: 'api_recommendations')]
    public function getRecommended(#[MapQueryParameter] ?string $algorithmName): Response
    {
        if (!$algorithmName) {
            throw new BadRequestException();
        }

        $recommendations = $this->recommendationGenerator->generate($algorithmName);

        if (null === $recommendations) {
            throw new BadRequestException();
        }

        return $this->json(
            array_map(
                static fn(RecommendableInterface $recommendable): string => $recommendable->getTitle(),
                $recommendations
            )
        );
    }

    #[Route('/api/recommendation_algorithms', name: 'api_recommendation_algorithms')]
    public function getAvailableAlgorithmNames(): Response
    {
        return $this->json(
            $this->recommendationGenerator->getAlgorithmNames()
        );
    }
}
