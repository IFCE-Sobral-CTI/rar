<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeekdayRequest;
use App\Http\Requests\UpdateWeekdayRequest;
use App\Models\Weekday;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class WeekdayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('weekdays.viewAny', Weekday::class);

        return Inertia::render('Admin/Weekday/Index', array_merge(Weekday::search($request), [
            'can' => [
                'view' => Auth::user()->can('weekdays.view'),
                'create' => Auth::user()->can('weekdays.create'),
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
        $this->authorize('weekdays.create', Weekday::class);

        return Inertia::render('Admin/Weekday/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(StoreWeekdayRequest $request): RedirectResponse
    {
        $this->authorize('weekdays.create', Weekday::class);

        try {
            $weekday = Weekday::create($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('weekdays.create')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('weekdays.show', $weekday)->with('flash', ['status' => 'success', 'message' => 'Registro salvo com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Weekday $weekday): Response
    {
        $this->authorize('weekdays.view', $weekday);

        return Inertia::render('Admin/Weekday/Show', [
            'weekday' => $weekday,
            'can' => [
                'delete' => Auth::user()->can('weekdays.delete'),
                'update' => Auth::user()->can('weekdays.update'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(Weekday $weekday): Response
    {
        $this->authorize('weekdays.update', $weekday);

        return Inertia::render('Admin/Weekday/Edit', [
            'weekday' => $weekday,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(UpdateWeekdayRequest $request, Weekday $weekday): RedirectResponse
    {
        $this->authorize('weekdays.update', $weekday);

        try {
            $weekday->update($request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('weekdays.show', $weekday)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('weekdays.show', $weekday)->with('flash', ['status' => 'success', 'message' => 'Registro atualizado com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Weekday $weekday): RedirectResponse
    {
        $this->authorize('weekdays.delete', $weekday);

        try {
            $weekday->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('weekdays.show', $weekday->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('weekdays.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
