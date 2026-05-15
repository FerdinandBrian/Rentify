<?php

namespace App\Services\User;

use App\Repositories\User\UserCarRepository;
use App\Repositories\User\UserDocumentRepository;
use App\Repositories\User\UserOrderRepository;

class UserNavigationService
{
    public function __construct(
        private readonly UserCarRepository $carRepository,
        private readonly UserDocumentRepository $documentRepository,
        private readonly UserOrderRepository $orderRepository
    ) {}

    public function metrics(int $userId): array
    {
        return [
            'pending_orders' => $this->orderRepository->countForUserByStatuses($userId, ['menunggu', 'pending']),
            'active_orders' => $this->orderRepository->countForUserByStatuses($userId, ['aktif', 'active']),
            'pending_documents' => $this->documentRepository->pendingCountForUser($userId),
            'approved_documents' => $this->documentRepository->approvedCountForUser($userId),
            'available_cars' => $this->carRepository->availableCarsCount(),
        ];
    }
}
