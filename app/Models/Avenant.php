<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'avenantNumber',
        'date',
        'avenantFilePath',
        'contract_id'
    ];

    public function contract(): BelongsTo 
    {
        return $this->belongsTo(Contract::class);
    }

}

