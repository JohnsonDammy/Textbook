<?php

namespace App\Interfaces\FurnitureRequest;

interface CollectFurnitureRepositoryInterface
{
    public function getSingleCollectionRequest($ref_no);
    public function acceptCollectFurniture($ref_no);
    public function addAcceptCollectFurnitureRequest(object $request);
}
