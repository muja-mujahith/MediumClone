<?php

namespace App\Models;

// use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'content',
        'user_id',
        'category_id',
        'published_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function readTime()
    {
        $wordcount = str_word_count(strip_tags($this->content));
        $minites = $wordcount / 100;
        return max(1, $minites);
    }

    public function imageUrl()
    {
        if($this->image)
        {
            return Storage::url($this->image);
        }
        return null;

    }
}
