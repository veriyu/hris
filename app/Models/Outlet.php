<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outlet extends Model
{
    use SoftDeletes;

    protected $fillable = ['company_id', 'code', 'name', 'address'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
