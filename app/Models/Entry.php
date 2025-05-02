<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'category_id']; 


    public $timestamps = true;

    // Relationship: An entry belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An entry may belong to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'entry_tag');
    }

}

