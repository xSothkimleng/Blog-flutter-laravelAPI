<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'image',
        'category',
        'description',
        'content',
        'author_id',
    ];
}
