<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Models\Report;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('reports.viewAny', Report::class);

        return Inertia::render('Admin/Report/Index', array_merge(Report::search($request), [
            'can' => [
                'view' => Auth::user()->can('reports.view'),
            ]
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report): Response
    {
        $this->authorize('reports.view', $report);

        return Inertia::render('Admin/Report/Show', [
            'report' => Report::getDataForShow($report),
            'dispatches' => Dispatch::getDataForReport($report),
            'can' => [
                'delete' => Auth::user()->can('reports.delete'),
                'update' => Auth::user()->can('reports.update'),
                'dispatch_view' => Auth::user()->can('dispatches.view'),
            ]
        ]);
    }

    public function update(UpdateReportRequest $request, Report $report): RedirectResponse
    {
        try {
            $report->update($request->validated());
            // Todo: criar rotina para criar um PDF e enviar para e-mail da reprografia
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('reports.show', $report->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('reports.show', $report->id)->with('flash', ['status' => 'success', 'message' => 'Registro enviado para impressão com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report): RedirectResponse
    {
        $this->authorize('reports.delete', $report);

        try {
            // Volta os registro para a fila de impressão
            foreach($report->dispatches as $dispatch) {
                PrintQueue::create([
                    'dispatch_id' => $dispatch->id
                ]);
            }

            $report->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('reports.show', $report->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('reports.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
