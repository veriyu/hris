<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'is_default',
    ];

    protected $casts = [
        'type' => \App\Enums\SalaryComponentType::class,
        'is_default' => 'boolean',
    ];

    public function employees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_salary_components')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
