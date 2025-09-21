<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = ['id'];

    protected $appends = ['logo_url', 'icon_url'];

    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? supaUrl($this->logo)
            : asset('img/default.png');
    }

    public function getIconUrlAttribute()
    {
        return $this->icon
            ? supaUrl($this->icon)
            : asset('img/default.png');
    }

}
