<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'price','user_id', 'published_at', 'image_url', 'image_extension', 'filename', 'url'];

    public function scopeFilter($query, array $filters) {


        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%');
        }
    }

    // Relationship To User
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

}
