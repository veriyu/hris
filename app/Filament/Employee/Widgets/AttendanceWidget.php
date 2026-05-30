<?php

namespace App\Filament\Employee\Widgets;

use Filament\Widgets\Widget;
use App\Models\Attendance;
use App\Actions\AttendanceAction;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class AttendanceWidget extends Widget
{
    protected string $view = 'filament.employee.widgets.attendance-widget';
    protected int | string | array $columnSpan = 'full';

    public ?Attendance $todayAttendance = null;

    public function mount()
    {
        $this->loadAttendance();
    }

    public function loadAttendance()
    {
        $employee = auth()->user()->employee;
        if ($employee) {
            $this->todayAttendance = Attendance::where('employee_id', $employee->id)
                ->where('date', Carbon::today()->format('Y-m-d'))
                ->first();
        }
    }

    public function checkIn(AttendanceAction $action)
    {
        try {
            $employee = auth()->user()->employee;
            
            if (!$employee) {
                throw new \Exception("Employee profile not found.");
            }
            $action->checkIn($employee);
            $this->loadAttendance();

            Notification::make()
                ->title('Checked In Successfully')
                ->success()
                ->send();

        } catch (ValidationException $e) {
            Notification::make()
                ->title('Check In Failed')
                ->body(collect($e->errors())->flatten()->first())
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function checkOut(AttendanceAction $action)
    {
        try {
            $employee = auth()->user()->employee;
            if (!$employee) {
                throw new \Exception("Employee profile not found.");
            }
            $action->checkOut($employee);
            $this->loadAttendance();

            Notification::make()
                ->title('Checked Out Successfully')
                ->success()
                ->send();

        } catch (ValidationException $e) {
            Notification::make()
                ->title('Check Out Failed')
                ->body(collect($e->errors())->flatten()->first())
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
