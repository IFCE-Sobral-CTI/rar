<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDispatchRequest;
use App\Http\Requests\UpdateDispatchRequest;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Models\Requirement;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Requirement $requirement, Request $request): Response
    {
        $this->authorize('dispatches.showAny', Dispatch::class);

        $requirement = Requirement::with(['enrollment' => ['student', 'course']])->find($requirement->id);

        return Inertia::render('Admin/Dispatch/Index', array_merge(Dispatch::search($requirement, $request), [
            'can' => [
                'view' => Auth::user()->can('dispatches.view'),
                'create' => Auth::user()->can('dispatches.create'),
            ],
            'requirement' => $requirement,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(Requirement $requirement): Response
    {
        $this->authorize('dispatches.create', Dispatch::class);

        $requirement = Requirement::with(['enrollment' => ['student', 'course']])->find($requirement->id);

        return Inertia::render('Admin/Dispatch/Create', [
            'requirement' => $requirement,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreDispatchRequest $request, Requirement $requirement): RedirectResponse
    {
        $this->authorize('dispatches.create', Dispatch::class);

        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $dispatch = $requirement->dispatches()->create($data);
            // Atualiza o status do Requerimento
            $requirement->update(['status' => $request->status]);
            // Adiciona o requerimento a fila de impressão
            if ($request->status === Dispatch::DEFERRED && $dispatch->requirement->requirementType->printable)
                $dispatch->printQueues()->create();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.dispatches.create', $requirement)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.dispatches.show', [$requirement, $dispatch])->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Requirement $requirement, Dispatch $dispatch): Response
    {
        $this->authorize('dispatches.show', $dispatch);

        $requirement = Requirement::with(['enrollment' => ['student', 'course']])->find($requirement->id);
        $dispatch = Dispatch::with(['user'])->find($dispatch->id);

        return Inertia::render('Admin/Dispatch/Show', [
            'dispatch' => $dispatch,
            'can' => [
                'delete' => Auth::user()->can('dispatches.delete'),
                'update' => Auth::user()->can('dispatches.update'),
            ],
            'requirement' => $requirement,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Requirement $requirement, Dispatch $dispatch): Response
    {
        $this->authorize('dispatches.update', $dispatch);

        $requirement = Requirement::with(['enrollment' => ['student', 'course']])->find($requirement->id);

        return Inertia::render('Admin/Dispatch/Edit', [
            'dispatch' => $dispatch,
            'requirement' => $requirement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateDispatchRequest $request, Requirement $requirement, Dispatch $dispatch): RedirectResponse
    {
        $this->authorize('dispatches.update', $dispatch);

        try {
            $dispatch->update($request->validated());

            // Verifica se é o ultimo despacho para o requerimento e atualiza o status
            $lastDispatch = $requirement->dispatches()->orderBy('id', 'DESC')->first()->id;
            if ($lastDispatch == $dispatch->id)
                $requirement->update(['status' => $request->status]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.dispatches.show', [$requirement, $dispatch])->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.dispatches.show', [$requirement, $dispatch])->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Requirement $requirement, Dispatch $dispatch): RedirectResponse
    {
        $this->authorize('dispatches.delete', $dispatch);

        try {
            $dispatches = $requirement->dispatches()->whereNotIn('id', [$dispatch->id])->orderBy('id', 'DESC');

            // Verifica se é o ultimo despacho e atualiza o status do requerimento
            $requirement->update(
                ['status' => !!$dispatches->count()? $dispatches->first()->status: Requirement::TO_ANALYZE]
            );

            $dispatch->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('requirements.dispatches.show', [$requirement, $dispatch])->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('requirements.dispatches.index', $requirement)->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
