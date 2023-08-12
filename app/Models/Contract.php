<?php

namespace App\Models;

use Panoscape\History\HasHistories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    use HasHistories;

    public function getModelLabel()
    {
        return $this->display_name;
    }

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

    public function avenants(): HasMany
    {
        return $this->hasMany(Avenant::class);
    }

    // Return image URL path
    public function imageUrl() : string
    {
        Storage::disk('public');
        
        return Storage::url($this->projectContractFilePath);
    }
}
