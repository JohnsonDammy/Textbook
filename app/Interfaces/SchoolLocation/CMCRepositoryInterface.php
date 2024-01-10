<?php

namespace App\Interfaces\SchoolLocation;

interface CMCRepositoryInterface
{
    public function getAllCMC();
    public function storeCMC(object $request);
    public function updateCMC(object $request, $id);
    public function getSingleCMC($id);
    public function deleteCMC($id);
    public function searchCMC($cmc_name);
}
