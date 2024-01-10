<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\DashboardRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    private DashboardRepositoryInterface $dashboardRepository;

    function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        //accessing  repository from App\Repositories\DashboardRepository.php
        $this->dashboardRepository = $dashboardRepository;
    }

    // get total count for dashboard chart
    public function getTotalCount()
    {
        try {
            $list = $this->dashboardRepository->getTotalCount();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list) ? "Records count" : "No data found", "data" => $list],  !empty($list) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // get pending collection list for dashboard chart
    public function getPandingCollection()
    {

        try {
            $list = $this->dashboardRepository->getPendingCollections();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Pending collection details" : "No data found", "data" =>  !empty($list['records']) ?  $list : null],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
    // get YTD count for dashboard chart
    public function getYTDStatusCount()
    {
        try {
            $list = $this->dashboardRepository->getYtdStatusCount();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list) ? "YTD status Count" : "No data found", "data" => $list],  !empty($list) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // download YTD  report for dashboard chart
    public function downloadYTDReport()
    {
        try {
            $list = $this->dashboardRepository->getYtdStatusCountReport();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "YTD status Count report data" : "No data found", "data" => $list['records']],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // get previous year status for dashboard chart
    public function getPreviousYearStatus()
    {
        try {
            $list = $this->dashboardRepository->previousYearStatusCount();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list) ? "Previous year status Count" : "No data found", "data" => $list],  !empty($list) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // download previous  report for dashboard chart
    public function downloadPreviousYearReport()
    {
        try {
            $list = $this->dashboardRepository->getpreviousYearCountReport();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list['records']) ? "Previous year status Count reportF" : "No data found", "data" => $list],  !empty($list['records']) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    // get progress collection details for dashboard chart
    public function  getProgressCollection()
    {

        try {
            $list = $this->dashboardRepository->getProgressCollectionCount();
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => !empty($list) ? "Progress % collection count" : "No data found", "data" => $list],  !empty($list) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}
