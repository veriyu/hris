<?php

namespace App\Actions;

use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeAction
{
    public function __construct(protected EmployeeService $employeeService)
    {
    }

    public function executeCreate(array $data): Employee
    {
        return $this->employeeService->createEmployee($data);
    }

    public function executeUpdate(Employee $employee, array $data): bool
    {
        return $this->employeeService->updateEmployee($employee, $data);
    }

    public function executeDelete(Employee $employee): bool
    {
        return $this->employeeService->deleteEmployee($employee);
    }
}
