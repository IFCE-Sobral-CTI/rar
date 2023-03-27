<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
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
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('courses.showAny', Course::class);

        return Inertia::render('Admin/Course/Index', array_merge(Course::search($request), [
            'can' => [
                'view' => Auth::user()->can('courses.view'),
                'create' => Auth::user()->can('courses.create'),
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
        $this->authorize('courses.create', Course::class);

        return Inertia::render('Admin/Course/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
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
     *
     * @throws AuthorizationException
     */
    public function show(Course $course): Response
    {
        $this->authorize('courses.show', $course);

        return Inertia::render('Admin/Course/Show', [
            'course' => $course,
            'can' => [
                'delete' => Auth::user()->can('courses.delete'),
                'update' => Auth::user()->can('courses.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Course $course): Response
    {
        $this->authorize('courses.update', $course);

        return Inertia::render('Admin/Course/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
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
     *
     * @throws AuthorizationException
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
