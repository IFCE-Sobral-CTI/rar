<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Enrollment extends Model
{
    use HasFactory, LogsActivity, CreatedAndUpdatedTz;

    protected $fillable = [
        'number', 'status', 'course_id', 'student_id'
    ];

    protected $casts = ['status' => 'boolean'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'number', 'status', 'course_id', 'student_id'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeSearch(Builder $query, Student $student, Request $request): array
    {
        $query = $student->enrollments()->with('course')->where(function($query) use ($request) {
            return $query->orWhereHas('course', function($query) use ($request) {
                return $query->where('name', 'iLIKE', "%{$request->term}%");
            })
            ->orWhere('number', 'iLIKE', "%{$request->term}%");
        });

        return [
            'count' => $query->count(),
            'enrollments' => $query->orderBy('number', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetDataForSelectInput(Builder $query): Collection
    {
        return $query->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->number . ' - ' . $item->student->name,
            ];
        });
    }
}
