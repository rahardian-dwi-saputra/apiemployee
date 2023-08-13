<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model{
    use HasFactory;
    
    protected $primaryKey = 'employee_id';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    public function department(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    
}
