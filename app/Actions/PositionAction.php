<?php

namespace App\Actions;

use App\Models\Position;
use App\Services\PositionService;

class PositionAction
{
    public function __construct(protected PositionService $positionService)
    {
    }

    public function executeCreate(array $data): Position
    {
        return $this->positionService->createPosition($data);
    }

    public function executeUpdate(Position $position, array $data): bool
    {
        return $this->positionService->updatePosition($position, $data);
    }

    public function executeDelete(Position $position): bool
    {
        return $this->positionService->deletePosition($position);
    }
}
