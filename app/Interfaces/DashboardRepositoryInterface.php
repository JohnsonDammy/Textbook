<?php

namespace App\Interfaces;

interface DashboardRepositoryInterface
{
    public function getTotalCount();
    public function getPendingCollections();
    public function getYtdStatusCount();
    public function getYtdStatusCountReport();
    public function getProgressCollectionCount();
    public function previousYearStatusCount();
    public function getpreviousYearCountReport();
}
