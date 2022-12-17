<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserEmailConfig extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'user_id', 'address', 'driver', 'username', 'password', 'encryption', 'host', 'port'];
    protected $table = 'user_emails_config';
    protected $hidden = [
        'driver',
        'host',
        'port',
        'encryption',
        'username',
        'password'
    ];

    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    
    public function scopeConfiguredEmail($query, $id) {

        return $query->where('id', $id);

    }

}
