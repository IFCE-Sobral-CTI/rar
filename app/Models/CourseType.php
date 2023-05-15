<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CourseType extends Model
{
    use HasFactory, LogsActivity, CreatedAndUpdatedTz;

    protected $fillable = [
        'description',
        'level'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'description',
                'level'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->where('description', 'like', "%{$request->term}%");

        return [
            'count' => $query->count(),
            'course_types' => $query->orderBy('description', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetIdByDescription(Builder $query, string $description): int
    {
        return $query->where('description', $description)->firstOrFail()->id;
    }

    public function scopeGetToForm(Builder $query): Collection
    {
        return $query->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->description,
            ];
        });
    }
}
