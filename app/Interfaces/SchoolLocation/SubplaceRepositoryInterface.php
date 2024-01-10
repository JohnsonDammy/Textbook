<?php

namespace App\Interfaces\SchoolLocation;

interface SubplaceRepositoryInterface
{
    public function getAllSubplaces();
    public function getSingleSubplace($id);
    public function storeSubplace(object $request);
    public function updateSubplace(object $request, $id);
    public function deleteSubplace($id);
    public function searchSubplace($data);
}
