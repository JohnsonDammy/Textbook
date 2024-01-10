<?php

namespace App\Interfaces\SchoolLocation;

interface DistrictRepositoryInterface
{


    
    public function getAllDistrict();
    public function getSingleDistrict($id);
    public function deleteDistrict($id);
    public function addDistrict(object $request);
    public function updateDistrict(object $request, $id);
    public function searchDistrict($query);
};
