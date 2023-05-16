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

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }

    public function printQueues(): HasMany
    {
        return $this->hasMany(PrintQueue::class);
    }

    public function scopeSearch(Builder $query, Requirement $requirement, Request $request): array
    {
        $query->with(['user'])
            ->where('requirement_id', $requirement->id)
            ->where(function($query) use ($request) {
                return $query->where('text', 'like', "%{$request->term}%")
                    ->orWhere('observation', 'like', "%{$request->term}%");
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

    public function scopeGetDataForReport(Builder $query, Report $report): array
    {
        $dispatch = $report->dispatches()->with(['requirement' => ['enrollment' => ['student'], 'semester', 'requirementType', 'weekdays']]);

        return [
            'count' => $dispatch->count(),
            'dispatches' => $dispatch->orderBy('status', 'ASC')->paginate(8),
        ];
    }

    /**
     * Retorna a quantidade de despachos feitos no semestre atual
     *
     * @param Builder $query
     * @return integer
     */
    public function scopeGetCount(Builder $query): int
    {
        return $query->whereHas('requirement', function($query) {
            $query->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            });
        })->count();
    }

    public function scopeGetDataForChart(Builder $query): array
    {
        $to_analyze = self::whereHas('requirement', function($query) {
            $query->where('status', self::TO_ANALYZE);
        })->count();

        $deferred = self::whereHas('requirement', function($query) {
            $query->where('status', self::DEFERRED);
        })->count();

        $rejected = self::whereHas('requirement', function($query) {
            $query->where('status', self::REJECTED);
        })->count();

        $result['labels'] = ['Para analise', 'Deferido', 'Indeferido'];

        $result['datasets'][] = [
            'label' => 'Qtd',
            'backgroundColor' => [
                'rgba(255, 206, 86, 0.75)', // Yellow
                'rgba(75, 192, 192, 0.75)', // Green
                'rgba(255, 99, 132, 0.75)', // Red
            ],
            'borderColor' => [
                'rgba(255, 206, 86, 1)', // Yellow
                'rgba(75, 192, 192, 1)', // Green
                'rgba(255, 99, 132, 1)', // Red
            ],
            'borderWidth' => 1,
            'data' => [$to_analyze, $deferred, $rejected]
        ];

        return $result;
    }
}
