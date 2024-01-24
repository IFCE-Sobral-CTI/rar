<?php

namespace App\Models;

use App\Enums\LevelOfEducation;
use App\Traits\CreatedAndUpdatedTz;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        'justification',
        'requirement_type_id',
        'enrollment_id',
        'semester_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'justification',
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
                    return $query->where('number', 'like', "%{$request->term}%")
                        ->orWhereHas('student', function($query) use ($request) {
                            return $query->where('name', 'like', "%{$request->term}%");
                        });
                });
            })
            ->orWhereHas('semester', function ($query) use ($request) {
                return $query->where('description', 'like', "%{$request->term}%");
            })
            ->orWhereHas('requirementType', function ($query) use ($request) {
                return $query->where('description', 'like', "%{$request->term}%");
            });
        });

        return [
            'count' => $query->count(),
            'requirements' => $query->orderBy('status', 'ASC')->orderBy('created_at', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetCount(Builder $query): int
    {
        return $query->whereHas('semester', function($query) {
            $query->where('start', '<=', now())->where('end', '>=', now());
        })->count();
    }

    public function scopeGetRenovationsCount(Builder $query): int
    {
        return $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Renovação');
        })
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })
            ->count();
    }

    public function scopeGetReprintCount(Builder $query): int
    {
        return $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Segunda via');
        })->whereHas('semester', function($query) {
            $query->where('start', '<=', now())->where('end', '>=', now());
        })->count();
    }

    public function scopeGetFirstCopyCount(Builder $query): int
    {
        return $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Primeira via');
        })->whereHas('semester', function($query) {
            $query->where('start', '<=', now())->where('end', '>=', now());
        })->count();
    }

    public function scopeGetDataOfRenovationsForChart(Builder $query): array
    {
        $renovations = $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Renovação');
        })
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        foreach($renovations as $renovation) {
            $result['labels'][] = Carbon::parse($renovation->date)->format('d/m/Y');
            $data[] = $renovation->count;
        }

        $result['datasets'][] = [
            'elements' => ['bar' => ['borderWidth' => 2]],
            'label' => 'Data',
            'backgroundColor' => 'rgba(255, 199, 32, 0.75)',
            'borderColor' => 'rgba(255, 199, 32, 1)',
            'data' => $data?? []
        ];

        return $result;
    }

    public function scopeGetDataOfFirstCopyForChart(Builder $query): array
    {
        $renovations = $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Primeira via');
        })
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        foreach($renovations as $renovation) {
            $result['labels'][] = Carbon::parse($renovation->date)->format('d/m/Y');
            $data[] = $renovation->count;
        }

        $result['datasets'][] = [
            'label' => 'Data',
            'backgroundColor' => 'rgba(105, 119, 192, 1)',
            'borderColor' => 'rgba(105, 119, 192, 0.25)',
            'data' => $data?? []
        ];

        return $result;
    }

    public function scopeGetDataOfReprintForChart(Builder $query): array
    {
        $renovations = $query->whereHas('requirementType', function($query) {
            $query->where('description', 'Segunda via');
        })
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        foreach($renovations as $renovation) {
            $result['labels'][] = Carbon::parse($renovation->date)->format('d/m/Y');
            $data[] = $renovation->count;
        }

        $result['datasets'][] = [
            'label' => 'Data',
            'backgroundColor' => 'rgba(255, 19, 32, 1)',
            'borderColor' => 'rgba(255, 19, 32, 0.25)',
            'data' => $data?? []
        ];

        return $result;
    }

    public function scopeGetDataByCourseForChart(Builder $query): array
    {
        $higher = self::whereHas('semester', function($query) {
            $query->where('start', '<=', now())->where('end', '>=', now());
        })->whereHas('enrollment', function($query) {
            $query->whereHas('course', function($query) {
                $query->whereHas('courseType', function($query) {
                    $query->where('level', LevelOfEducation::higher->value);
                });
            });
        })->count();

        $technical = self::whereHas('semester', function($query) {
            $query->where('start', '<=', now())->where('end', '>=', now());
        })->whereHas('enrollment', function($query) {
            $query->whereHas('course', function($query) {
                $query->whereHas('courseType', function($query) {
                    $query->where('level', LevelOfEducation::technical->value);
                });
            });
        })->count();

        $result['labels'] = ['Técnico', 'Superior'];

        $result['datasets'][] = [
            'label' => 'Qtd',
            'backgroundColor' => [
                'rgba(54, 162, 235, 0.75)',
                'rgba(75, 192, 192, 0.75)'
            ],
            'borderColor' => [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            'borderWidth' => 1,
            'data' => [$technical, $higher]
        ];

        return $result;
    }

    public function scopeGetDataByStatusForChart(Builder $query): array
    {
        $to_analyze = self::where('status', self::TO_ANALYZE)
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })->count();

        $deferred = self::where('status', self::DEFERRED)
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
            })->count();

        $rejected = self::where('status', self::REJECTED)
            ->whereHas('semester', function($query) {
                $query->where('start', '<=', now())->where('end', '>=', now());
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

    public function scopeReports(Builder $query, Request $request, bool $print = false): array|Collection
    {
        $query->with(['enrollment' => ['student'], 'semester', 'requirementType', 'weekdays']);

        $query->when($request->status, function($query) use ($request) {
            return $query->where('status', $request->status);
        });

        $query->when($request->type, function($query) use ($request) {
            return $query->whereHas('requirementType', function($query) use ($request) {
                return $query->where('id', $request->type);
            });
        });

        $query->when($request->course, function($query) use ($request) {
            return$query->whereHas('enrollment', function($query) use  ($request) {
                return $query->whereHas('course', function($query) use ($request) {
                    return $query->whereHas('courseType', function($query) use ($request) {
                        return $query->where('level', $request->course);
                    });
                });
            });
        });

        $query->when($request->semester, function($query) use ($request) {
            return $query->whereHas('semester', function($query) use ($request) {
                return $query->where('id', $request->semester);
            });
        });

        $query->when($request->init_date, function($query) use ($request) {
            return $query->where('created_at', '>=' ,$request->init_date);
        });

        $query->when($request->final_date, function($query) use ($request) {
            return $query->where('created_at', '<=' ,$request->final_date);
        });

        // Dados para impressão
        if ($print)
            return  $query->orderBy('status', 'ASC')->get();

        return [
            'count' => $query->count(),
            'requirements' => $query->orderBy('status', 'ASC')->orderBy('created_at', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends([
                'status' => $request->status,
                'type' => $request->type,
                'course' => $request->course,
                'semester' => $request->semester,
            ]),
        ];
    }

    public function scopeGetDescriptionFiltersForPrint(Builder $query, Request $request): array
    {
        $status = $request->status? match((int)$request->status) {
            self::TO_ANALYZE => 'Para analise',
            self::DEFERRED => 'Deferido',
            self::REJECTED => 'Indeferido',
            default => null,
        }: null;

        $course = $request->course? LevelOfEducation::get($request->course): null;
        $semester = Semester::where('id', $request->semester)->first()?->description;
        $type = RequirementType::where('id', $request->type)->first()?->description;

        return [
            'status' => $status,
            'semester' => $semester,
            'course' => $course,
            'type' => $type,
        ];
    }

    public function getStatus(): string
    {
        return match($this->status) {
            self::TO_ANALYZE => 'Para analise',
            self::DEFERRED => 'Deferido',
            self::REJECTED => 'Indeferido',
        };
    }
}
