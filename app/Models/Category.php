<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = ['name', 'description', 'user_id'];

    // Relationship: Category belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
