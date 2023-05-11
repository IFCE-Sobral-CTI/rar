<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Services\Pdf;
use Exception;
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
     */
    public function index(Request $request): Response
    {
        $this->authorize('print_queues.viewAny', PrintQueue::class);

        return Inertia::render('Admin/PrintQueue/Index', array_merge(PrintQueue::search($request), [
            'can' => [
                'view' => Auth::user()->can('print_queues.view'),
            ]
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(PrintQueue $queue): Response
    {
        $this->authorize('print_queues.view', $queue);

        return Inertia::render('Admin/PrintQueue/Show', [
            'printQueue' => PrintQueue::getDataForShow($queue),
            'can' => [
                'delete' => Auth::user()->can('print_queues.delete'),
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrintQueue $queue): RedirectResponse
    {
        $this->authorize('print_queues.delete', $queue);

        try {
            Dispatch::create([
                'status' => Dispatch::REJECTED,
                'text' => 'Removido da fila de impressão.',
                'requirement_id' => $queue->dispatch->requirement->id,
                'user_id' => Auth::user()->id,
            ]);
            $queue->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('print_queues.show', $queue->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('print_queues.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }

    public function send(Request $request, Pdf $pdf): ?RedirectResponse
    {
        $this->authorize('print_queues.send', PrintQueue::class);

        if (!PrintQueue::count())
            return to_route('print_queues.index')->with('flash', ['status' => 'warning', 'message' => 'Nenhum registro para imprimir.']);

        try {
            $report = $request->user()->reports()->create();
            $report->dispatches()->sync(
                PrintQueue::all()->unique('dispatch_id')->pluck('dispatch_id')->toArray()
            );
            // Remove todos da fila de impressão
            PrintQueue::truncate();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('print_queues.index')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }
        // Gera o PDF e redireciona para o index das filas de impressão
        return $pdf->generate($report);
    }
}
