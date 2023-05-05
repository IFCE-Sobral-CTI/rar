<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PrintQueue extends Model
{
    use HasFactory, CreatedAndUpdatedTz, LogsActivity;

    protected $fillable = [
        'dispatch_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'dispatch_id',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(Dispatch::class);
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->with(['dispatch' => ['requirement' => ['enrollment' => ['student', 'course'], 'requirementType'], 'user']])
            ->whereHas('dispatch', function($query) use ($request) {
                return $query->whereHas('requirement', function($query) use ($request) {
                    return $query->whereHas('enrollment', function($query) use ($request) {
                        return $query->where(function($query) use ($request) {
                            return $query->orWhereHas('student', function($query) use ($request) {
                                return $query->where('name', 'like', "%$request->term%");
                            })->orWhere('number', 'like', "%$request->term%");
                        });
                    });
                });
            });

        return [
            'count' => $query->count(),
            'printQueues' => $query->orderBy('id', 'DESC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetDataForShow(Builder $query, PrintQueue $printQueue): PrintQueue
    {
        return $query->with([
            'dispatch' => [
                'requirement' =>
                [
                    'enrollment' => ['student', 'course'],
                    'requirementType'
                ],
                'user'
            ]
        ])->findOrFail($printQueue->id);
    }
}
