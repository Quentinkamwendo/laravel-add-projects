<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'project_name', 'description', 'start_date', 'end_date', 'image'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
