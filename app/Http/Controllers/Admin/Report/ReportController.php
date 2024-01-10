<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionRequestSearch;
use App\Interfaces\Reports\ReportsRepositoryInterface;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

use function PHPSTORM_META\type;

class ReportController extends Controller
{
    private ReportsRepositoryInterface $reportRepository;
    public function __construct(ReportsRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->middleware('permission:report-list', [
            'only' =>
            [
                'replenishment', 'replenishmentSearch', 'replenishmentDownload',
                'disposal', 'disposalSearch', 'disposalDownload',
                'stock', 'stockSearch', 'stockDownload',
                'furnitureCount', 'furnitureCountSearch', 'furnitureCountDownload',
                'repairment', 'repairmentSearch', 'repairmentDownload',
                'transaction', 'transactionSearch', 'transactionDownload',
                'transactionStatus', 'transactionStatusSearch', 'transactionStatusDownload',
                'getExcel'
            ]
        ]);
    }
    public function reporthome(Request $request)
    {
        return view('furniture.reports.report_home');
    }

    public function replenishment(Request $request)
    {
        $data = $this->reportRepository->getReplenishmentReport($request);
        return view('furniture.reports.replenishment_report', ['data' => $data]);
    }

    public function replenishmentSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null && $request->replenishment_status == null && $request->category_id == null && $request->start_date == null && $request->end_date == null && $request->item_id == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getReplenishmentReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.replenishment_report', ['data' => $data]);
            }
            return redirect('/reports/replenishment')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }

    public function replenishmentDownload(Request $request)
    {
        $data = $this->reportRepository->getReplenishmentReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function disposal(Request $request)
    {
        $data = $this->reportRepository->getDisposalReport($request);
        return view('furniture.reports.disposal_report', ['data' => $data]);
    }

    public function disposalSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null && $request->item_id == null && $request->category_id == null && $request->start_date == null && $request->end_date == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getDisposalReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.disposal_report', ['data' => $data]);
            }
            return redirect('/reports/disposal')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }

    public function disposalDownload(Request $request)
    {
        $data = $this->reportRepository->getDisposalReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function stock(Request $request)
    {
        if (Auth::user()->organization != 2) {
            $data = $this->reportRepository->getManufacturerStockManagementReport($request);
            return view('furniture.reports.stock_report', ['data' => $data]);
        } else {
            return redirect('/reports');
        }
    }
    public function stockSearch(Request $request)
    {
        if (Auth::user()->organization != 2) {
            if ($request->category == null && $request->item == null) {
                return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
            } else {
                $data = $this->reportRepository->getManufacturerStockManagementReport($request);
                if (!empty($data['records'])) {
                    return view('furniture.reports.stock_report', ['data' => $data]);
                }
                return redirect('/reports/stock')->with('searcherror', 'Your search did not match any records.');
            }
        } else {
            return redirect('/reports');
        }
    }

    public function stockDownload(Request $request)
    {
        if (Auth::user()->organization != 2) {
            $data = $this->reportRepository->getManufacturerStockManagementReport($request);
            $xls = $this->getExcel($data['records']);
            return $xls;
        } else {
            return redirect('/reports');
        }
    }



    public function furnitureCount(Request $request)
    {
        $data = $this->reportRepository->getSchoolFurnitureCountReport($request);
        // dd($data);
        return view('furniture.reports.furniture-count_report', ['data' => $data]);
    }

    public function furnitureCountSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null && $request->category_id == null && $request->item_id == null && $request->start_date == null && $request->end_date == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getSchoolFurnitureCountReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.furniture-count_report', ['data' => $data]);
            }
            return redirect('/reports/furniture-count')->with('searcherror', 'Your search did not match any records.');
        }
    }

    public function furnitureCountDownload(Request $request)
    {
        $data = $this->reportRepository->getSchoolFurnitureCountReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function repairment(Request $request)
    {
        $data = $this->reportRepository->getRepairmentReport($request);
        // dd($data);
        return view('furniture.reports.repairment_report', ['data' => $data]);
    }

    public function repairmentSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null && $request->category_id == null && $request->item_id == null && $request->start_date == null && $request->end_date == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getRepairmentReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.repairment_report', ['data' => $data]);
            }
            return redirect('/reports/repairment')->with('searcherror', 'Your search did not match any records.');
        }
    }

    public function repairmentDownload(Request $request)
    {
        $data = $this->reportRepository->getRepairmentReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function transaction(Request $request)
    {
        $data = $this->reportRepository->getTransactionSummaryReport($request);
        // dd($data);
        return view('furniture.reports.transactions_summary_report', ['data' => $data]);
    }

    public function transactionSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null  && $request->start_date == null && $request->end_date == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getTransactionSummaryReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.transactions_summary_report', ['data' => $data]);
            }
            return redirect('/reports/transaction-summary')->with('searcherror', 'Your search did not match any records.');
        }
    }
    public function transactionDownload(Request $request)
    {
        $data = $this->reportRepository->getTransactionSummaryReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function transactionStatus(Request $request)
    {
        $data = $this->reportRepository->getTransactionStatusReport($request);
        // dd($data);
        return view('furniture.reports.transaction_status_report', ['data' => $data]);
    }

    public function transactionStatusSearch(Request $request)
    {
        if ($request->school_name == null && $request->district_office == null && $request->status_id == null && $request->start_date == null && $request->end_date == null) {
            return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
        } else {
            $data = $this->reportRepository->getTransactionStatusReport($request);
            if (!empty($data['records'])) {
                return view('furniture.reports.transaction_status_report', ['data' => $data]);
            }
            return redirect('/reports/transaction-status')->with('searcherror', 'Your search did not match any records.');
        }
    }
    public function transactionStatusDownload(Request $request)
    {
        $data = $this->reportRepository->getTransactionStatusReport($request);
        $list = $data['records'];
        //cheking all element are type of array  and having unwanted data
        foreach ($list as $key => $list1) {
            foreach ($list1 as $key2 => $value) {
                if (gettype($value) == 'array' || $value == "NA") {
                    // removing array element from array if element is array type
                    unset($list[$key][$key2]);
                }
            }
        }

        $xls = $this->getExcel($list);
        return $xls;
    }

    public function getExcel($list)
    {
        //cheking all element are type of array 
        foreach ($list as $key => $list1) {
            foreach ($list1 as $key2 => $value) {
                if (gettype($value) == 'array') {
                    // removing array element from array if element is array type
                    unset($list[$key][$key2]);
                }
            }
        }
        // setting headers to excel fetching from array indexes
        $sheet_headers = array_keys($list[0]);
        $spreadSheet = new Spreadsheet();
        $aplha = range("A", "Z");



        // add style to the header
        $styleArray = [
            'font' => [
                "bold" => true
            ],
            "borders" => [
                "bottom" => [
                    "borderStyle" => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    "color" => ["rgb" => '333333']
                ]
            ]
        ];

        foreach ($sheet_headers as $key => $value) {

            // Changing the names AFTER UAT furniture category to Iten Category and Furniture Item to ITEM Description
            $header_name =  strtoupper(str_replace("_", " ", $value));
            if ($value == 'furniture_category') {
                $header_name = 'ITEM CATEGORY';
            } else if ($value == 'furniture_item') {
                $header_name = 'ITEM DESCRIPTION';
            } else if ($value == 'school_inventory_count') {
                $header_name = 'LEARNER ENROLMENT';
            } else if ($value == 'replenishment_count') {
                $header_name = 'REPLENISHMENT REQUESTED COUNT';
            } else {
                $header_name =  strtoupper(str_replace("_", " ", $value));
            }

            $spreadSheet->getActiveSheet()->setCellValue($aplha[$key] . 1, $header_name);
        }


        $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
        $spreadSheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
        $row = 2;
        foreach ($list as $key => $value) {
            foreach ($sheet_headers as $key => $header) {
                $spreadSheet->getActiveSheet()->setCellValue($aplha[$key++] . $row, $value[$header]);
            }
            $row++;
        }
        $Excel_writer = new Xls($spreadSheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Customer_ExportedData.xls"');
        header('Cache-Control: max-age=0');
        if (ob_get_length() > 0) {
            ob_clean();
        }
        $Excel_writer->save('php://output');
        return $Excel_writer;
    }
}
