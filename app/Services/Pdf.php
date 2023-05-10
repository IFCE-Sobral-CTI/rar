<?php

namespace App\Services;

use App\Models\Report;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Pdf extends Dompdf
{
    /**
     * Create a new pdf instance.
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * Determine id the use wants to download or view.
     */
    public function action(): string
    {
        return request()->has('download') ? 'attachment' : 'inline';
    }


    /**
     * Render the PDF.
     */
    public function generate(Report $report): RedirectResponse
    {
        try {
            $report = Report::with(['dispatches' => ['requirement' => ['enrollment' => ['student', 'course']]]])->find($report->id);
            $this->loadHtml(
                View::make('print', [
                    'report' => $report->dispatches->chunk(10),
                ])->render()
            );
            $this->render();
            $report->update([
                'file' => sprintf('public/pdf/%s.pdf', Str::random(20))
            ]);
            Storage::put($report->file, $this->output());
        } catch (Exception $e) {
            return to_route('print_queues.index')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }
        return to_route('reports.index')->with('flash', ['status' => 'success', 'message' => 'Registro enviados para impressão com sucesso.']);
    }
}
