<?php

namespace App\Interfaces\Stock;

interface ItemRepositoryInterface
{
    public function getAllItems();
    public function getSingleItem($id);
    public function addItem(object $request);
    public function updateItem(object $request, $id);
    public function deleteItem($id);
    public function searchItem($query);
}
