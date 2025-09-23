<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activity(): belongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }



}
