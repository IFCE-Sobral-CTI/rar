<?php

namespace App\Models;

use App\Traits\CreatedAndUpdatedTz;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, LogsActivity, CreatedAndUpdatedTz;

    protected $fillable = [
        'cpf',
        'rg',
        'name',
        'birth',
        'personal_email',
        'institutional_email'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'cpf',
                'rg',
                'name',
                'birth',
                'personal_email',
                'institutional_email'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Returns the date in the defined timezone
     */
    public function getBirthAttribute(string $date): string
    {
        return Carbon::parse($date)->setTimezone(env('APP_TIMEZONE', 'UTC'))->format('d/m/Y');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeSearch(Builder $query, Request $request): array
    {
        $query->where('cpf', 'like', "%{$request->term}%")
            ->orWhere('rg', 'like', "%{$request->term}%")
            ->orWhere('name', 'like', "%{$request->term}%")
            ->orWhereHas('enrollments', function($query) use ($request) {
                return $query->where('number', 'like', "%{$request->term}%");
            });

        return [
            'count' => $query->count(),
            'students' => $query->orderBy('name', 'ASC')->paginate(env('APP_PAGINATION', 10))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }
}
