<?php

namespace App\Interfaces\FurnitureRequest;

interface CollectionRequestRepositoryInterface
{
    
    public function getAllRequest();
    public function getAllManageRequest();
    public function getSchoolRequest();
    public function checkActiveRequest();
    public function AddCollectionRequest(object $request);
    public function EditCollectionRequest(object $request, $id);
    public function searchRequest(object $request);
    public function deleteCollectionRequest($id);
}