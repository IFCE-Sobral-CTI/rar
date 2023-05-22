<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequirementRequest;
use App\Http\Requests\UpdateRequirementRequest;
use App\Models\Enrollment;
use App\Models\Requirement;
use App\Models\RequirementType;
use App\Models\Semester;
use App\Models\Weekday;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('requirements.viewAny', Requirement::class);

        return Inertia::render('Admin/Requirement/Index', array_merge(Requirement::search($request), [
            'can' => [
                'view' => $request->user()->can('requirements.view'),
                'create' => $request->user()->can('requirements.create'),
            ]
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('requirements.create', Requirement::class);

        return Inertia::render('Admin/Requirement/Create', [
            'enrollments' => fn () => Enrollment::getDataForSelectInput(),
            'requirement_types' => RequirementType::getDataForSelectInput(),
            'weekdays' => Weekday::getDataForSelectInput(),
            'semesters' => Semester::getDataForSelectInput(),
            'reprint_type' => RequirementType::where('description', 'Segunda via')->first()->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreRequirementRequest $request): RedirectResponse
    {
        $this->authorize('requirements.create', Requirement::class);

        try {
            $requirement = Requirement::create($request->only(['status', 'semester_id', 'enrollment_id', 'requirement_type_id', 'justification']));
            $requirement->weekdays()->sync($request->weekday);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.show', $requirement)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Request $request, Requirement $requirement): Response
    {
        $this->authorize('requirements.view', $requirement);

        $requirement = Requirement::with(['enrollment' => ['student', 'course'], 'weekdays', 'semester', 'requirementType'])->find($requirement->id);

        return Inertia::render('Admin/Requirement/Show', [
            'requirement' => $requirement,
            'can' => [
                'delete' => $request->user()->can('requirements.delete'),
                'update' => $request->user()->can('requirements.update'),
                'dispatches' => $request->user()->can('dispatches.index'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Requirement $requirement): Response
    {
        $this->authorize('requirements.update', $requirement);

        $requirement = Requirement::with(['enrollment' => ['student'], 'weekdays:id,description', 'semester', 'requirementType'])->find($requirement->id);

        return Inertia::render('Admin/Requirement/Edit', [
            'requirement' => $requirement,
            'enrollments' => fn () => Enrollment::getDataForSelectInput(),
            'requirement_types' => RequirementType::getDataForSelectInput(),
            'weekdays' => Weekday::getDataForSelectInput(),
            'semesters' => Semester::getDataForSelectInput(),
            'reprint_type' => RequirementType::where('description', 'Segunda via')->first()->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateRequirementRequest $request, Requirement $requirement): RedirectResponse
    {
        $this->authorize('requirements.update', $requirement);

        try {
            $requirement->update($request->validated());
            $requirement->weekdays()->sync($request->weekday);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.show', $requirement)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.show', $requirement)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Requirement $requirement): RedirectResponse
    {
        $this->authorize('requirements.delete', $requirement);

        try {
            $requirement->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.show', $requirement->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
