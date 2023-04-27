<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequirementTypeRequest;
use App\Http\Requests\UpdateRequirementTypeRequest;
use App\Models\RequirementType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequirementTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('types.viewAny', RequirementType::class);

        return Inertia::render('Admin/RequirementType/Index', array_merge(RequirementType::search($request), [
            'can' => [
                'view' => Auth::user()->can('types.view'),
                'create' => Auth::user()->can('types.create'),
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
        $this->authorize('types.create', RequirementType::class);

        return Inertia::render('Admin/RequirementType/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreRequirementTypeRequest $request): RedirectResponse
    {
        $this->authorize('types.create', RequirementType::class);

        try {
            $type = RequirementType::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('types.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('types.show', $type)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(RequirementType $type): Response
    {
        $this->authorize('types.view', $type);

        return Inertia::render('Admin/RequirementType/Show', [
            'type' => $type,
            'can' => [
                'delete' => Auth::user()->can('types.delete'),
                'update' => Auth::user()->can('types.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(RequirementType $type): Response
    {
        $this->authorize('types.update', $type);

        return Inertia::render('Admin/RequirementType/Edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateRequirementTypeRequest $request, RequirementType $type): RedirectResponse
    {
        $this->authorize('types.update', $type);

        try {
            $type->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('types.show', $type)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('types.show', $type)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(RequirementType $type): RedirectResponse
    {
        $this->authorize('types.delete', $type);

        try {
            $type->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('types.show', $type->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('types.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
