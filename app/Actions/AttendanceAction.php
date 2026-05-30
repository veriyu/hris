<?php

namespace App\Actions;

use App\Models\Attendance;
use App\Models\Employee;
use App\Enums\AttendanceStatus;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AttendanceAction
{
    /**
     * Threshold for being marked as late (08:10 AM)
     */
    private const LATE_THRESHOLD_TIME = '08:10:00';

    /**
     * Handle employee check in
     */
    public function checkIn(Employee $employee): Attendance
    {
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if already checked in today
        $existing = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today->format('Y-m-d'))
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'attendance' => 'You have already checked in today.',
            ]);
        }

        // Determine status
        $status = AttendanceStatus::PRESENT;
        
        // Check if late (after 08:10:00)
        $lateThreshold = Carbon::parse($today->format('Y-m-d') . ' ' . self::LATE_THRESHOLD_TIME);
        if ($now->greaterThan($lateThreshold)) {
            $status = AttendanceStatus::LATE;
        }

        return Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today->format('Y-m-d'),
            'check_in' => $now,
            'status' => $status,
        ]);
    }

    /**
     * Handle employee check out
     */
    public function checkOut(Employee $employee): Attendance
    {
        $today = Carbon::today();
        $now = Carbon::now();

        // Find today's attendance
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today->format('Y-m-d'))
            ->first();

        if (!$attendance) {
            throw ValidationException::withMessages([
                'attendance' => 'You must check in first before checking out.',
            ]);
        }

        if ($attendance->check_out) {
            throw ValidationException::withMessages([
                'attendance' => 'You have already checked out today.',
            ]);
        }

        $attendance->update([
            'check_out' => $now,
        ]);

        return $attendance;
    }
}
