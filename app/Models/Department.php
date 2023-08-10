<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model{
    
    public $timestamps = false;
    
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
