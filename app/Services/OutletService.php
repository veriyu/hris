<?php

namespace App\Services;

use App\Models\Outlet;

class OutletService
{
    public function createOutlet(array $data): Outlet
    {
        return Outlet::create($data);
    }

    public function updateOutlet(Outlet $outlet, array $data): bool
    {
        return $outlet->update($data);
    }

    public function deleteOutlet(Outlet $outlet): bool
    {
        return $outlet->delete();
    }
}
