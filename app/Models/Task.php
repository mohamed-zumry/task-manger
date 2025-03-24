<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority', 'description', 'status', 'start_date', 'project_id'];

    // Scope to filter tasks by project_id
    public function scopeProjectId($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    // Scope to filter tasks by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Eager load the project relationship
    public function project(): BelongsTo
    {

        return $this->belongsTo(Project::class);

    }
}
