<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class EmployeeService
{
    public function generateEmployeeNumber(): string
    {
        $year = date('Y');
        $latest = Employee::where('employee_number', 'like', "EMP-{$year}-%")->latest('id')->first();
        
        if (! $latest) {
            return "EMP-{$year}-00001";
        }
        
        $number = intval(substr($latest->employee_number, -5)) + 1;
        return "EMP-{$year}-" . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public function createEmployee(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $employeeNumber = $this->generateEmployeeNumber();
            
            // Create user account
            $user = User::create([
                'name' => $data['first_name'] . ' ' . ($data['last_name'] ?? ''),
                'email' => strtolower(str_replace(' ', '.', $data['first_name'])) . mt_rand(100,999) . '@hrms.com', // fallback fake email
                'employee_number' => $employeeNumber,
                'password' => Hash::make('password'),
            ]);
            
            // Assign employee role
            $user->assignRole('Employee');
            
            $employeeData = array_merge($data, [
                'employee_number' => $employeeNumber,
                'user_id' => $user->id,
            ]);
            
            return Employee::create($employeeData);
        });
    }

    public function updateEmployee(Employee $employee, array $data): bool
    {
        return DB::transaction(function () use ($employee, $data) {
            $result = $employee->update($data);
            
            if ($employee->user) {
                $employee->user->update([
                    'name' => $data['first_name'] . ' ' . ($data['last_name'] ?? ''),
                ]);
            }
            
            return $result;
        });
    }

    public function deleteEmployee(Employee $employee): bool
    {
        return DB::transaction(function () use ($employee) {
            if ($employee->user) {
                $employee->user->delete();
            }
            return $employee->delete();
        });
    }
}
