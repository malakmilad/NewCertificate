<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }
    public function enrollmentTemplates()
    {
        return $this->hasMany(EnrollmentTemplate::class);
    }
}
