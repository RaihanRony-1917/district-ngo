<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    //
    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? supaUrl($this->image)
            : asset('img/default.png');
    }


    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
