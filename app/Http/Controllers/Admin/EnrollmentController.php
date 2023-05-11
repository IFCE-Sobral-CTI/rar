<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EnrollmentController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Student $student, Request $request): Response
    {
        $this->authorize('enrollments.viewAny', Enrollment::class);

        return Inertia::render('Admin/Enrollment/Index', array_merge(Enrollment::search($student, $request), [
            'can' => [
                'view' => Auth::user()->can('enrollments.view'),
                'create' => Auth::user()->can('enrollments.create'),
            ],
            'student' => $student
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student): Response
    {
        $this->authorize('enrollments.create', Enrollment::class);

        return Inertia::render('Admin/Enrollment/Create', [
            'student' => $student,
            'courses' => Course::select('id', 'name')->orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Student $student, StoreEnrollmentRequest $request): RedirectResponse
    {
        $this->authorize('enrollments.create', Enrollment::class);

        try {
            $enrollment = $student->enrollments()->create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.enrollments.create', $student->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.enrollments.show', ['enrollment' => $enrollment, 'student' => $student])->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     */
    public function show( Student $student, Enrollment $enrollment): Response
    {
        $this->authorize('enrollments.view', $enrollment);

        return Inertia::render('Admin/Enrollment/Show', [
            'enrollment' => Enrollment::with(['course', 'student'])->find($enrollment->id),
            'can' => [
                'delete' => Auth::user()->can('enrollments.delete'),
                'update' => Auth::user()->can('enrollments.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student, Enrollment $enrollment): Response
    {
        $this->authorize('enrollments.update', $enrollment);

        return Inertia::render('Admin/Enrollment/Edit', [
            'enrollment' => Enrollment::with(['course', 'student'])->find($enrollment->id),
            'courses' => Course::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, Student $student, Enrollment $enrollment): RedirectResponse
    {
        $this->authorize('enrollments.update', $enrollment);

        try {
            $enrollment->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.enrollments.show', ['enrollment' => $enrollment, 'student' => $student])->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.enrollments.show', ['enrollment' => $enrollment, 'student' => $student])->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student, Enrollment $enrollment): RedirectResponse
    {
        $this->authorize('enrollments.delete', $enrollment);

        try {
            $enrollment->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.enrollments.show', ['enrollment' => $enrollment, 'student' => $student])->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.enrollments.index', $student)->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
