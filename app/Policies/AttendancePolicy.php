<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Super Admin', 'HR']) || $user->employee?->id === $attendance->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'HR', 'Employee']); // Employee can check in
    }

    public function update(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Super Admin', 'HR']);
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    public function restore(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    public function forceDelete(User $user, Attendance $attendance): bool
    {
        return $user->hasRole(['Super Admin']);
    }
}
