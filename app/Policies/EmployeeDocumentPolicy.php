<?php

namespace App\Policies;

use App\Models\EmployeeDocument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeeDocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmployeeDocument $employeeDocument): bool
    {
        return $user->hasRole(['Super Admin', 'HR']) || $user->id === $employeeDocument->employee->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeDocument $employeeDocument): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeDocument $employeeDocument): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmployeeDocument $employeeDocument): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeDocument $employeeDocument): bool
    {
        return $user->hasRole(['Super Admin']);
    }
}
