<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTemplate extends Model
{
    use HasFactory;
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
