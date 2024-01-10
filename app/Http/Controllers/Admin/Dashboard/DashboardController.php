<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\DashboardRepositoryInterface;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class DashboardController extends Controller
{
    private DashboardRepositoryInterface $dashboardRepository;
    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->middleware('permission:dashboard-list', ['only' => [
            'index', 'statusCountBarChart', 'progressPieChart', 'previousCountTreeMap',
            'pendingCollectionsDownload', 'ytdStatusCountDownload', 'previousYearCountDownload'
        ]]);
    }

    public function index()
    {
        $count = $this->dashboardRepository->getTotalCount();
        $pendingCollections = $this->dashboardRepository->getPendingCollections();
        $ytdStatusCount = $this->statusCountBarChart();
        $progressPercent = $this->progressPieChart();
        $previousCount = $this->previousCountTreeMap();
        return view('furniture.dashboard.dashboard', [
            'count' => $count, 'pending_collections' => $pendingCollections,
            'ytd_status_count' => $ytdStatusCount, 'progress_percent' => $progressPercent,
            'previous_year_count' => $previousCount
        ]);
    }

    public function statusCountBarChart()
    {
        $barChart = "[";
        $ytdStatusCount = $this->dashboardRepository->getYtdStatusCount();
        foreach ($ytdStatusCount as $key => $count) {
            $barChart .= "$count, ";
        }
        $barChart = rtrim($barChart, ' ,');
        $barChart .= "]";
        return $barChart;
    }

    public function progressPieChart()
    {

        $pieChart = "[";
        $progressPercent = $this->dashboardRepository->getProgressCollectionCount();
        foreach ($progressPercent as $key => $count) {
            $name = ucwords(str_replace("_", " ", $key));
            $pieChart .= "{
                name: '$name - $count %',
                y: $count
            },";
        }
        $pieChart = rtrim($pieChart, ' ,');
        $pieChart .= "]";
        return $pieChart;
    }

    public function previousCountTreeMap()
    {
       
        $columnChart = "[";
        $progressPercent = $this->dashboardRepository->previousYearStatusCount();
        foreach ($progressPercent as $key => $count) {
            $name = ucwords(str_replace("_", " ", $key));
            $columnChart .= "{
                name: '$name - $count',
                data: [$count]
            },";
        }
        $columnChart = rtrim($columnChart, ' ,');
        $columnChart .= "]";
        return $columnChart;
    }

    public function pendingCollectionsDownload(Request $request)
    {
        $data = $this->dashboardRepository->getPendingCollections($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function ytdStatusCountDownload(Request $request)
    {
        $data = $this->dashboardRepository->getYtdStatusCountReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function previousYearCountDownload(Request $request)
    {
        $data = $this->dashboardRepository->getpreviousYearCountReport($request);
        $xls = $this->getExcel($data['records']);
        return $xls;
    }

    public function getExcel($list)
    {
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
            $spreadSheet->getActiveSheet()->setCellValue($aplha[$key] . 1, strtoupper(str_replace("_", " ", $value)));
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
