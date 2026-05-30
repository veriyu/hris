<?php

namespace App\Services;

use App\Models\Position;

class PositionService
{
    public function createPosition(array $data): Position
    {
        return Position::create($data);
    }

    public function updatePosition(Position $position, array $data): bool
    {
        return $position->update($data);
    }

    public function deletePosition(Position $position): bool
    {
        return $position->delete();
    }
}
