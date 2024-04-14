<?php

declare(strict_types=1);

namespace App\Recommendation\Controller;

use App\Recommendation\Service\RecommendationGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecommendationController extends AbstractController
{
    public function __construct(private readonly RecommendationGenerator $recommendationGenerator)
    {
    }

    #[Route('/api/recommendations', name: 'api_recommendations')]
    public function getRecommended(): Response
    {
        return $this->json(
            $this->recommendationGenerator->generate()
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
