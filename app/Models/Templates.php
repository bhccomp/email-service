<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','template_name', 'content'];

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }
}
