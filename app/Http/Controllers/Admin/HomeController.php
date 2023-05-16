<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Dispatch;
use App\Models\PrintQueue;
use App\Models\Report;
use App\Models\Requirement;
use App\Models\Semester;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'can' => [
                'print_queue_view' => $request->user()->can('print_queues.show')
            ],
            'requirements' => [
                'renovations' => Requirement::getRenovationsCount(),
                'renovations_chart' => Requirement::getDataOfRenovationsForChart(),
                'reprint' => Requirement::getReprintCount(),
                'reprint_chart' => Requirement::getDataOfReprintForChart(),
                'first_copy' => Requirement::getFirstCopyCount(),
                'first_copy_chart' => Requirement::getDataOfFirstCopyForChart(),
                'count' => Requirement::getCount(),
            ],
            'dispatches' => [
                'count' => Dispatch::getCount(),
                'chart' => Dispatch::getDataForChart(),
            ],
            'print_queue' => [
                'list' => PrintQueue::getDataForDashboardChart(),
                'count' => PrintQueue::count()
            ],
            'print' => [
                'count' => Report::getRequirementCount(),
                'printed' => Report::getPrinted(),
                'chart' => Report::getDataForChart(),
            ],
            'semester' => Semester::getCurrent(),
            'courses' => [
                'chart' => Course::getDataForChart()
            ]
        ]);
    }
}
