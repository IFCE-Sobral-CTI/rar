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

    protected $fillable = [
        'description',
        'status',
        'printable',
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
        return $query->select('id', 'description')->where('status', true)->get();
    }

    public function scopeGetDataForSelectInput(Builder $query, ?bool $status = true): Collection
    {
        if (is_null($status))
            return $query->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->description,
                ];
            });

        return $query->where('status', true)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->description,
            ];
        });
    }
}
