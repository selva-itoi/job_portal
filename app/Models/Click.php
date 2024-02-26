<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['jobs_id', 'user_agent', 'ip'];

    public function Jobs()
    {
        return $this->belongsTo(Jobs::class);
    }
}
