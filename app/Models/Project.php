<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
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

     public function category(){
        return $this->belongsTo(ProjectCategory::class);
    }
}
