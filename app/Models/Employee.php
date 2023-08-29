<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model{
    use HasFactory;
    
    protected $primaryKey = 'employee_id';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;

    protected function hireDate(): Attribute{
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y')
        );
    }
    protected function dateOfBirth(): Attribute{
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y')
        );
    }
    protected function salary(): Attribute{
        return Attribute::make(
            get: fn (string $value) => number_format($value,0,'.','.')
        );
    }
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    
}
