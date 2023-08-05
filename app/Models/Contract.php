<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractNumber',
        'contractType',
        'startDate',
        'endDate',
        'projectContractFilePath',
        'employee_im'
    ];

    public function employee(): BelongsTo 
    {
        return $this->belongsTo(Employee::class, 'employee_im', 'im');
    }

    public function avenant(): HasMany
    {
        return $this->hasMany(Avenant::class);
    }
}
