<?php

namespace App\Actions;

use App\Models\Department;
use App\Services\DepartmentService;

class DepartmentAction
{
    public function __construct(protected DepartmentService $departmentService)
    {
    }

    public function executeCreate(array $data): Department
    {
        return $this->departmentService->createDepartment($data);
    }

    public function executeUpdate(Department $department, array $data): bool
    {
        return $this->departmentService->updateDepartment($department, $data);
    }

    public function executeDelete(Department $department): bool
    {
        return $this->departmentService->deleteDepartment($department);
    }
}
