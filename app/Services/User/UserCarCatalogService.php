<?php

namespace App\Services\User;

use App\Cars\Filters\BrandFilter;
use App\Cars\Filters\DateAvailabilityFilter;
use App\Cars\Filters\SearchFilter;
use App\Cars\Filters\TypeFilter;
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
            'cars' => $this->carRepository->paginateAvailableCars($filters, $this->carFilters()),
            'brands' => $this->carRepository->brands(),
            'types' => $this->carRepository->types(),
        ];
    }

    public function detailData(string $seriesNumber, int $userId): array
    {
        $car = $this->carRepository->findWithBrand($seriesNumber);

        $hasSubmittedFeedback = $car->feedback()
            ->where('User_id', $userId)
            ->exists();

        return [
            'car' => $car,
            'relatedCars' => $this->carRepository->relatedCars($car),
            'verifiedDocuments' => $this->documentRepository->approvedCountForUser($userId),
            'hasSubmittedFeedback' => $hasSubmittedFeedback,
        ];
    }

    private function carFilters(): array
    {
        return [
            new BrandFilter,
            new TypeFilter,
            new SearchFilter,
            new DateAvailabilityFilter,
        ];
    }
}
