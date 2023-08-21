<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LevelOfEducation;
use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Models\RequirementType;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RequirementReportController extends Controller
{
    public function index(Request $request): Response
    {
        $this->authorize('requirement_reports.viewAny', Requirement::class);

        return Inertia::render('Admin/Requirement/Reports', [
            'can' => [
                'view' => $request->user()->can('requirements.view'),
                'create' => $request->user()->can('requirements.create'),
            ],
            'requirements' => Requirement::reports($request),
            'request' => [
                'status' => $request->status,
                'type' => $request->type,
                'course' => $request->course,
                'semester' => $request->semester,
                'page' => $request->page,
            ],
            'data' => [
                'type_of_course' => [
                    ['id' => LevelOfEducation::higher, 'name' => LevelOfEducation::higher->description()],
                    ['id' => LevelOfEducation::technical, 'name' => LevelOfEducation::technical->description()],
                ],
                'type_of_requirement' => RequirementType::getDataForSelectInput(status: null),
                'semester' => Semester::getDataForSelectInput(),
                'status' => [
                    ['id' => Requirement::TO_ANALYZE, 'name' => 'Em analise'],
                    ['id' => Requirement::DEFERRED, 'name' => 'Deferido'],
                    ['id' => Requirement::REJECTED, 'name' => 'Indeferido'],
                ]
            ]
        ]);
    }

    public function print(Request $request): View
    {
        $this->authorize('requirement_reports.viewAny', Requirement::class);

        return view('printRequirement', [
            'filters' => Requirement::getDescriptionFiltersForPrint($request),
            'requirements' => Requirement::reports(request: $request, print: true),
            'user' => $request->user()->name
        ]);
    }
}
