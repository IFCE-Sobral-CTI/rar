<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\CourseType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('courses.viewAny', Course::class);

        return Inertia::render('Admin/Course/Index', array_merge(Course::search($request), [
            'can' => [
                'view' => Auth::user()->can('courses.view'),
                'create' => Auth::user()->can('courses.create'),
            ]
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('courses.create', Course::class);

        return Inertia::render('Admin/Course/Create', [
            'types' => CourseType::getToForm()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->authorize('courses.create', Course::class);

        try {
            $course = Course::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('courses.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('courses.show', $course)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): Response
    {
        $this->authorize('courses.view', $course);

        //dd(Course::with(['type'])->find($course->id));

        return Inertia::render('Admin/Course/Show', [
            'course' => Course::with(['courseType'])->find($course->id),
            'can' => [
                'delete' => Auth::user()->can('courses.delete'),
                'update' => Auth::user()->can('courses.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): Response
    {
        $this->authorize('courses.update', $course);

        return Inertia::render('Admin/Course/Edit', [
            'course' => $course,
            'types' => CourseType::getToForm()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('courses.update', $course);

        try {
            $course->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('courses.show', $course)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('courses.show', $course)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('courses.delete', $course);

        try {
            $course->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('courses.show', $course->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('courses.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
