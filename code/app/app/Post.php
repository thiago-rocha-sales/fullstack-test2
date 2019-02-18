<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = [
        'title', 
        'slug', 
        'body', 
        'image', 
        'published',
        'author_id'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function authors()
    {
        return $this->hasMany('App\Author');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
