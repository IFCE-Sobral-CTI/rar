<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RequirementType extends Model
{
    use HasFactory, LogsActivity, CreatedAndUpdatedTz;

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'status', // 1 => active, 2 => inactive
        'printable', // 1 => yes, 2 => no
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'description',
                'status',
                'printable',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->where('description', 'like', "%{$request->term}%");

        return [
            'count' => $query->count(),
            'requirementTypes' => $query->orderBy('description', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }

    public function scopeGetActiveTypes(Builder $query): Collection
    {
        return $query->select('id', 'description')->where('status', 1)->get();
    }

    public function scopeGetDataForSelectInput(Builder $query, ?int $status = 1): Collection
    {
        if (is_null($status))
            return $query->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->description,
                ];
            });

        return $query->where('status', 1)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->description,
            ];
        });
    }
}
