<?php

namespace App\Services\User;

use App\Cars\Strategies\BrandFilterStrategy;
use App\Cars\Strategies\DateAvailabilityFilterStrategy;
use App\Cars\Strategies\SearchFilterStrategy;
use App\Cars\Strategies\TypeFilterStrategy;
use App\Repositories\User\UserCarRepository;
use App\Repositories\User\UserDocumentRepository;

class UserCarCatalogService
{
    public function __construct(
        private readonly UserCarRepository $carRepository,
        private readonly UserDocumentRepository $documentRepository
    ) {}

    public function catalogData(array $filters): array
    {
        return [
            'cars' => $this->carRepository->paginateAvailableCars($filters, $this->filterStrategies()),
            'brands' => $this->carRepository->brands(),
            'types' => $this->carRepository->types(),
        ];
    }

    public function detailData(string $seriesNumber, int $userId): array
    {
        $car = $this->carRepository->findWithBrand($seriesNumber);

        return [
            'car' => $car,
            'relatedCars' => $this->carRepository->relatedCars($car),
            'verifiedDocuments' => $this->documentRepository->approvedCountForUser($userId),
        ];
    }

    private function filterStrategies(): array
    {
        return [
            new BrandFilterStrategy,
            new TypeFilterStrategy,
            new SearchFilterStrategy,
            new DateAvailabilityFilterStrategy,
        ];
    }
}
