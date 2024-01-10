<?php

namespace App\Interfaces;

interface SchoolRepositoryInterface
{
    public function getAllSchool();
    public function getSingleSchool($id);
    public function addSchool(object $request);
    public function updateSchool(object $request, $id);
    public function deleteSchool($id);
    public function searchSchool($query);
};
