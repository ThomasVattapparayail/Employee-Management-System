<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employees;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'logo', 'website'];

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }
}
