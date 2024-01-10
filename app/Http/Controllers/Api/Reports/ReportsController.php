<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Interfaces\Reports\ReportsRepositoryInterface;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    private ReportsRepositoryInterface $reportrepo;

    function __construct(ReportsRepositoryInterface $reportrepo)
    {
        $this->reportrepo = $reportrepo;
        $this->middleware('api_permission:report-list', ['only' => ['getReplenishmentReport', 'getDisposalReport', 'getManufacturerStockManagementReport', 'getSchoolFurnitureCountReport', 'getRepairmentReport', 'getTransactionSummaryReport', 'getTransactionStatusReport', 'downloadReplenishedReports']]);
    }

    // getting replenishment report for reports
    public function getReplenishmentReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getReplenishmentReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Replenishment report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting disposal report for reports
    public function getDisposalReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getDisposalReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Disposal report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting Manufacturere Stock Management report for reports
    public function getManufacturerStockManagementReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getManufacturerStockManagementReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Manufacturer Stock report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting School furniture count report for reports
    public function getSchoolFurnitureCountReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getSchoolFurnitureCountReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "School Furniture Count report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting repairment report for reports
    public function getRepairmentReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getRepairmentReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Repairment report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting transaction summery report for reports
    public function getTransactionSummaryReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getTransactionSummaryReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Transaction summery report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // getting Transaction status report for reports
    public function getTransactionStatusReport(Request $request)
    {
        try {
            $list = $this->reportrepo->getTransactionStatusReport($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Transaction Status report list" : (Request::input("search") == 'true' ? " Your search did not match any record" : "No Data Found"), "data" => !empty($list['records']) ? $list : null], !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    // downloading replenishment report for reports

    public function downloadReplenishedReports(Request $request)
    {
        $data = $this->reportrepo->getReplenishmentReport($request);
        if ($data) {
            $list = [];
            if (count($data) > 0) {
                foreach ($data as $key => $request) {
                    foreach ($request->getBrokenItems as $key2 => $item) {
                        $list[] = [
                            "school_name" => $request->school_name,
                            "school_emis" => $request->emis,
                            "district_office" => $request->getDistrict()->district_office,
                            "ref_number" => $request->ref_number,
                            "transaction_date" => $request->created_at->toDateString(),
                            "furniture_category" => $item->getCategoryDetails->name,
                            "replenished_count" => $item->replenished_count,
                            "replenishment_status" => $request->getReplenishStatus->name,
                            "total_per_school" => "No data"
                        ];
                    }
                }
            }
            return $list;
        }
    }
}
