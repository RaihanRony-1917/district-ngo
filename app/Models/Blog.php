<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    //
    protected $guarded = ['id'];


    protected $casts = [
        'tags'=> 'array',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? supaUrl($this->image)
            : asset('img/default.png');
    }
}
