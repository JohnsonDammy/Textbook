<?php

namespace App\Interfaces\Reports;

interface ReportsRepositoryInterface
{
    public function getReplenishmentReport(object $request);
    public function getDisposalReport(object $request);
    public function getManufacturerStockManagementReport(object $request);
    public function getSchoolFurnitureCountReport(object $request);
    public function getRepairmentReport(object $request);
    public function getTransactionSummaryReport(object $request);
    public function getTransactionStatusReport(object $request);
}
