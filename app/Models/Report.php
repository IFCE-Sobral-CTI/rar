<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends Model
{
    use HasFactory, CreatedAndUpdatedTz, LogsActivity;

    protected $fillable = [
        'user_id',
        'printed',
        'file'
    ];

    public function dispatches(): BelongsToMany
    {
        return $this->belongsToMany(Dispatch::class);
    }

    public function tokens(): MorphMany
    {
        return $this->morphMany(AccessToken::class, 'tokenable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'user.name',
                'printed',
                'file'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->with(['dispatches' => ['requirement' => ['enrollment' => ['student', 'course'], 'requirementType']], 'user'])
            ->whereHas('dispatches', function($query) use ($request) {
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
            'reports' => $query->orderBy('id', 'DESC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetDataForShow(Builder $query, Report $report): Report
    {
        return $query->with([
            'dispatches' => [
                'requirement' =>
                [
                    'enrollment' => ['student', 'course'],
                    'requirementType'
                ],
            ],
            'user'
        ])->findOrFail($report->id);
    }

    public function scopeGetRequirementCount(Builder $query): int
    {
        $counter = 0;

        foreach($query->get() as $item)
            $counter += $item->dispatches()->whereHas('requirement', function($query) {
                $query->whereHas('semester', function($query) {
                    $query->where('start', '<=', now())->where('end', '>=', now());
                });
            })->count();

        return $counter;
    }

    public function scopeGetPrinted(Builder $query): int
    {
        return $query->where('printed', true)->count();
    }

    public function scopeGetDataForChart(Builder $query): array
    {
        $reports = $query->whereHas('dispatches', function($query) {
            $query->whereHas('requirement', function($query) {
                $query->whereHas('semester', function($query) {
                    $query->where('start', '<=', now())->where('end', '>=', now());
                });
            });
        })
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        foreach($reports as $report) {
            $result['labels'][] = Carbon::parse(strtotime($report->created_at))->format('d/m/Y');
            $data[] = $report->dispatches()->count();
        }

        $result['datasets'][] = [
            'label' => 'Data',
            'backgroundColor' => 'rgba(255, 199, 32, 0.75)',
            'borderColor' => 'rgba(255, 199, 32, 1)',
            'data' => $data?? []
        ];

        return $result;
    }
}
