<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructionPage extends Model
{
    use Traits\SlugTrait;

    protected $fillable = ['title', 'description', 'picture', 'instruction', 'slug'];

    public static function booted()
    {
        static::saving(function($post){
            if ($post->isDirty('title')){
              $post->slug = $post->createSlug($post->title);
            }
        });
    }
}
