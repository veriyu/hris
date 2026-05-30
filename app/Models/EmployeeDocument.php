<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDocument extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'document_type' => DocumentType::class,
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
