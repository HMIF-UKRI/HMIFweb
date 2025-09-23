<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory;

    protected $table = 'blog_categories';
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'blog_category_id');
    }
}
