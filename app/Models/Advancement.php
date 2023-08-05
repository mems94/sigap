<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advancement extends Model
{
    use HasFactory;

    protected $fillable = [
        'class',
        'echelon',
        'indice',
        'category',
        'employee_im'
    ];

    public function employee(): BelongsTo 
    {
        return $this->belongsTo(Employee::class, 'employee_im', 'im');
    }
}
