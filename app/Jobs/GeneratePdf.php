<?php

namespace App\Jobs;
use App\Models\savedtextbookitems; // Update the namespace as needed
use App\Models\School; // Update the namespace as needed
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $emis;
    public function __construct($emis)
    {
        $this->emis = $emis;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(2020);

        $remainingDigits = substr($this->emis, 3);

        $querySavedItems = savedtextbookitems::all();
        $dataSavedTextbook = $querySavedItems;

        $schoolname = School::where('emis', $this->emis)->value('name');

        $pdf = PDF::loadView('Section21_C.RequestQuotation.GenPdf', [
            'dataSavedTextbook' => $dataSavedTextbook,
            'emis' => $remainingDigits,
            'schoolname' => $schoolname,
        ])->setPaper('a3', 'landscape');

        $fileName = uniqid() . "_" . $this->emis . "_" . "TextbookQuote.pdf";

        $pdf->save('public/GenPdf/' . $fileName);

        DB::table('doc_quote')->insert([
            'Emis' => $this->emis,
            'FileName' => $fileName,
        ]);

        
    }
}
