<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Models\Report;
use App\Models\Requirement;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PrintQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('print_queues.showAny', PrintQueue::class);

        return Inertia::render('Admin/PrintQueue/Index', array_merge(PrintQueue::search($request), [
            'can' => [
                'view' => Auth::user()->can('print_queues.view'),
            ]
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(PrintQueue $queue): Response
    {
        $this->authorize('print_queues.show', $queue);

        return Inertia::render('Admin/PrintQueue/Show', [
            'printQueue' => PrintQueue::getDataForShow($queue),
            'can' => [
                'delete' => Auth::user()->can('print_queues.delete'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException
     */
    public function edit(PrintQueue $print_queue): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, PrintQueue $print_queue): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(PrintQueue $queue): RedirectResponse
    {
        $this->authorize('print_queues.delete', $queue);

        try {
            $queue->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('print_queues.show', $queue->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('print_queues.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }

    public function send(Request $request): RedirectResponse
    {
        $this->authorize('print_queues.send', PrintQueue::class);

        try {
            $report = $request->user()->reports()->create();
            $report->requirements()->sync(
                Dispatch::getIdRequirements(
                    PrintQueue::all()->pluck('dispatch_id')->toArray()
                )
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('print_queues.index')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('print_queues.index')->with('flash', ['status' => 'success', 'message' => 'Registro enviados para impressão com sucesso.']);
    }
}
