<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'department_id',
        'category_id',
        'assigned_to',
        'created_by',
        'priority',
        'status',
        'address',
        'neighborhood',
        'latitude',
        'longitude',
        'due_date',
        'cancel_reason',
        'source',
        'reporter_name',
        'reporter_tc',
        'reporter_phone',
        'tracking_code',
    ];

    protected function casts(): array
    {
        return [
            'priority' => TaskPriority::class,
            'status' => TaskStatus::class,
            'due_date' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function category(): BelongsTo
{
    return $this->belongsTo(TaskCategory::class, 'category_id');
}

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(TaskUpdate::class);
    }
}