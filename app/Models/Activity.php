<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class Activity extends ModelsActivity
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d/m/Y H:i:s',
        'updated_at' => 'date:d/m/Y H:i:s',
    ];

    public function scopeSearch(Builder $query, Request $request)
    {
        $query->with('causer')->whereHas('causer', function ($query) use ($request) {
            return $query->where('name', 'iLIKE', "%".$request->term."%");
        })
        ->orWhere('subject_type', 'iLIKE', '%'.$request->term.'%');

        return [
            'count' => $query->count(),
            'activities' => $query->orderBy('created_at', 'DESC')->paginate(env('APP_PAGINATION'))->appends(['term' => $request->term]),
            'page' => $request->page?? 1,
            'termSearch' => $request->term,
        ];
    }
}
