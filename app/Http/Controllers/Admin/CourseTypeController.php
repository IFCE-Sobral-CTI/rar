<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LevelOfEducation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseTypeRequest;
use App\Http\Requests\UpdateCourseTypeRequest;
use App\Models\CourseType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('course_types.viewAny', CourseType::class);

        return Inertia::render('Admin/CourseType/Index', array_merge(CourseType::search($request), [
            'can' => [
                'view' => $request->user()->can('course_types.view'),
                'create' => $request->user()->can('course_types.create'),
            ]
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('course_types.create', CourseType::class);

        return Inertia::render('Admin/CourseType/Create', [
            'levels' => array_map(function($key, $index) {
                return ['id' => $key, 'name' => $index];
            }, array_keys(LevelOfEducation::toArray()), LevelOfEducation::toArray()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseTypeRequest $request): RedirectResponse
    {
        $this->authorize('course_types.create', CourseType::class);

        try {
            $type = CourseType::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('course_types.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('course_types.show', $type)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CourseType $type): Response
    {
        $this->authorize('course_types.view', $type);

        return Inertia::render('Admin/CourseType/Show', [
            'course_type' => $type,
            'can' => [
                'delete' => $request->user()->can('course_types.delete'),
                'update' => $request->user()->can('course_types.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseType $type): Response
    {
        $this->authorize('course_types.update', $type);

        return Inertia::render('Admin/CourseType/Edit', [
            'course_type' => $type,
            'levels' => array_map(function($key, $index) {
                return ['id' => $key, 'name' => $index];
            }, array_keys(LevelOfEducation::toArray()), LevelOfEducation::toArray()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseTypeRequest $request, CourseType $type): RedirectResponse
    {
        $this->authorize('course_types.update', $type);

        try {
            $type->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('course_types.show', $type)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('course_types.show', $type)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseType $type): RedirectResponse
    {
        $this->authorize('course_types.delete', $type);

        try {
            $type->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('course_types.show', $type->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('course_types.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
