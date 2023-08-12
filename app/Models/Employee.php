<?php

namespace App\Models;

use Panoscape\History\HasHistories;
use Panoscape\History\HasOperations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use HasHistories;

    public function getModelLabel()
    {
        return $this->display_name;
    }

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
            'user_id'
    ];

    public function advancements(): HasMany
    {
        return $this->hasMany(Advancement::class, 'employee_im', 'im');
    }

    public function contracts(): HasMany
    {
        // return $this->hasOne(Contract::class, 'employee_im', 'im');
        return $this->hasMany(Contract::class, 'employee_im', 'im');
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}
