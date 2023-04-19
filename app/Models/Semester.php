<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Semester extends Model
{
    use HasFactory, CreatedAndUpdatedTz, LogsActivity;

    protected $fillable = [
        'description',
        'start',
        'end'
    ];

    protected $casts = [
        'start' => 'date:d/m/Y',
        'end' => 'date:d/m/Y',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'description',
                'start',
                'end'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->where('description', 'iLIKE', "%{$request->term}%");

        return [
            'count' => $query->count(),
            'semesters' => $query->orderBy('start', 'DESC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }
}
