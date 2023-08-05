<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

     /**
     * The primary key associated with the table.
     *
     * @var integer
     */
    protected $primaryKey = 'im';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
            'im',
            'lastName',
            'firstName',
            'address',
            'contact',
            'gender',
            'lastDegree',
    ];

    public function advancement(): HasOne 
    {
        return $this->hasOne(Advancement::class, 'employee_im', 'im');
    }

    public function contract(): HasOne 
    {
        return $this->hasOne(Contract::class, 'employee_im', 'im');
    }


    // Retourne le path vers l'image 
    public function imageUrl() : string
    {
        Storage::disk('public');
        
        return Storage::url($this->projectContractFile_path);
    }
}
