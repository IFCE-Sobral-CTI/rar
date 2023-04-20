<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Requirement extends Model
{
    use HasFactory, CreatedAndUpdatedTz, LogsActivity;

    public const TO_ANALYZE = 1;
    public const DEFERRED = 2;
    public const REJECTED = 3;
    protected $fillable = [
        'status',
        'requirement_type_id',
        'enrollment_id',
        'semester_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status',
                'requirementType.description',
                'enrollment.name',
                'semester.description',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function requirementType(): BelongsTo
    {
        return $this->belongsTo(RequirementType::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function weekdays(): BelongsToMany
    {
        return $this->belongsToMany(Weekday::class);
    }

    public function dispatches(): HasMany
    {
        return $this->hasMany(Dispatch::class);
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->with(['enrollment' => ['student'], 'semester', 'requirementType', 'weekdays'])->where(function($query) use ($request) {
            return $query->orWhereHas('enrollment', function($query) use ($request) {
                return $query->where(function($query) use ($request) {
                    return $query->where('number', 'iLIKE', "%{$request->term}%")
                        ->orWhereHas('student', function($query) use ($request) {
                            return $query->where('name', 'iLIKE', "%{$request->term}%");
                        });
                });
            })
            ->orWhereHas('semester', function ($query) use ($request) {
                return $query->where('description', 'iLIKE', "%{$request->term}%");
            })
            ->orWhereHas('requirementType', function ($query) use ($request) {
                return $query->where('description', 'iLIKE', "%{$request->term}%");
            });
        });

        return [
            'count' => $query->count(),
            'requirements' => $query->orderBy('status', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }
}
