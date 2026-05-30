<?php

namespace App\Actions;

use App\Models\Outlet;
use App\Services\OutletService;

class OutletAction
{
    public function __construct(protected OutletService $outletService)
    {
    }

    public function executeCreate(array $data): Outlet
    {
        return $this->outletService->createOutlet($data);
    }

    public function executeUpdate(Outlet $outlet, array $data): bool
    {
        return $this->outletService->updateOutlet($outlet, $data);
    }

    public function executeDelete(Outlet $outlet): bool
    {
        return $this->outletService->deleteOutlet($outlet);
    }
}
