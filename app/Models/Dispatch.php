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

class Dispatch extends Model
{
    use HasFactory, CreatedAndUpdatedTz, LogsActivity;

    public const TO_ANALYZE = 1;
    public const DEFERRED = 2;
    public const REJECTED = 3;

    protected $fillable = [
        'status',
        'text',
        'observation',
        'requirement_id',
        'user_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status',
                'text',
                'observation',
                'requirement.enrollment.number',
                'user.name',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, Requirement $requirement, Request $request): array
    {
        $query->with(['user'])
            ->where('requirement_id', $requirement->id)
            ->where(function($query) use ($request) {
                return $query->where('text', 'iLIKE', "%{$request->term}%")
                    ->orWhere('observation', 'iLIKE', "%{$request->term}%");
            });

        return [
            'count' => $query->count(),
            'dispatches' => $query->orderBy('id', 'DESC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetIdRequirements(Builder $query, array $dispatches): array
    {
        return $query->whereIn('id', $dispatches)->get()->unique('requirement_id')->pluck('requirement_id')->toArray();
    }
}
