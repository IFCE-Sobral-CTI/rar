<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('students.viewAny', Student::class);

        return Inertia::render('Admin/Student/Index', array_merge(Student::search($request), [
            'can' => [
                'view' => Auth::user()->can('students.view'),
                'create' => Auth::user()->can('students.create'),
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
        $this->authorize('students.create', Student::class);

        return Inertia::render('Admin/Student/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->authorize('students.create', Student::class);

        try {
            $student = Student::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.show', $student)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Student $student): Response
    {
        $this->authorize('students.view', $student);

        return Inertia::render('Admin/Student/Show', [
            'student' => $student,
            'can' => [
                'delete' => Auth::user()->can('students.delete'),
                'update' => Auth::user()->can('students.update'),
                'enrollment' =>
                    Auth::user()->can('enrollments.viewAny')
                    && Auth::user()->can('enrollments.view')
                    && Auth::user()->can('enrollments.update')
                    && Auth::user()->can('enrollments.delete'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Student $student): Response
    {
        $this->authorize('students.update', $student);

        return Inertia::render('Admin/Student/Edit', [
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $this->authorize('students.update', $student);

        try {
            $student->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.show', $student)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.show', $student)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('students.delete', $student);

        try {
            $student->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('students.show', $student->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('students.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
