<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //

    protected $guarded = ['id'];

    protected $appends = ['image_url', 'icon_url'];

    public function getImageUrlAttribute()
    {
        return $this->image
            ? supaUrl($this->image)
            : asset('img/default.png');
    }

    public function getIconUrlAttribute()
    {
        return asset('storage/' . $this->icon);
    }
}
