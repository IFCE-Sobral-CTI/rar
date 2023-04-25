<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Models\Report;
use App\Models\Requirement;
use Exception;
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
        $this->authorize('reports.showAny', Report::class);

        return Inertia::render('Admin/Report/Index', array_merge(Report::search($request), [
            'can' => [
                'view' => Auth::user()->can('reports.view'),
            ]
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report): Response
    {
        $this->authorize('reports.show', $report);

        return Inertia::render('Admin/Report/Show', [
            'report' => Report::getDataForShow($report),
            'requirements' => Requirement::getDataForReport($report),
            'can' => [
                'delete' => Auth::user()->can('reports.delete'),
                'requirement_view' => Auth::user()->can('requirements.view'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $this->authorize('reports.delete', $report);

        try {
            // Volta os registro para a fila de impressão
            foreach($report->requirements as $requirement) {
                $dispatch = $requirement->dispatches()->where('status', Dispatch::DEFERRED)->orderBy('id', 'DESC');
                if ($dispatch->count()) {
                    PrintQueue::create([
                        'dispatch_id' => $dispatch->first()->id
                    ]);
                }
            }
            $report->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('reports.show', $report->id)->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        return to_route('reports.index')->with('flash', ['status' => 'success', 'message' => 'Registro apagado com sucesso.']);
    }
}
