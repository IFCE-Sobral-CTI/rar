<?php

namespace App\Services;

use App\Models\Report;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

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
     *
     * @param  \App\Invoice  $invoice
     * @return string
     */
    public function generate(Report $report): string
    {
        $report = Report::with(['dispatches' => ['requirement' => ['enrollment' => ['student', 'course']]]])->find($report->id);

        $this->loadHtml(
            View::make('print', [
                'report' => $report->dispatches->chunk(10),
            ])->render()
        );

        $this->render();

        Storage::put('public/pdf/'.$report->id.'.pdf', $this->output());

        return $this->output();
    }
}
