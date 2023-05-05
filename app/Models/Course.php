<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends Model
{
    use HasFactory, LogsActivity, CreatedAndUpdatedTz;

    protected $fillable = [
        'name', 'cod', 'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'cod',
                'status'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->where('name', 'like', "%{$request->term}%")
            ->orWhere('cod', 'like', "%{$request->term}%");

        return [
            'count' => $query->count(),
            'courses' => $query->orderBy('name', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }
}
