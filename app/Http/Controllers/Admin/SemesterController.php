<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('semesters.showAny', Semester::class);

        return Inertia::render('Admin/Semester/Index', array_merge(Semester::search($request), [
            'can' => [
                'view' => Auth::user()->can('semesters.view'),
                'create' => Auth::user()->can('semesters.create'),
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
        $this->authorize('semesters.create', Semester::class);

        return Inertia::render('Admin/Semester/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreSemesterRequest $request): RedirectResponse
    {
        $this->authorize('semesters.create', Semester::class);

        try {
            $semester = Semester::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('semesters.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('semesters.show', $semester)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Semester $semester): Response
    {
        $this->authorize('semesters.show', $semester);

        return Inertia::render('Admin/Semester/Show', [
            'semester' => $semester,
            'can' => [
                'delete' => Auth::user()->can('semesters.delete'),
                'update' => Auth::user()->can('semesters.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Semester $semester): Response
    {
        $this->authorize('semesters.update', $semester);

        return Inertia::render('Admin/Semester/Edit', [
            'semester' => $semester,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateSemesterRequest $request, Semester $semester): RedirectResponse
    {
        $this->authorize('semesters.update', $semester);

        try {
            $semester->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('semesters.show', $semester)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('semesters.show', $semester)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Semester $semester): RedirectResponse
    {
        $this->authorize('semesters.delete', $semester);

        try {
            $semester->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('semesters.show', $semester->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('semesters.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
