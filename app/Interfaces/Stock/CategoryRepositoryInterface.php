<?php 

namespace App\Interfaces\Stock;
interface CategoryRepositoryInterface{

    public function getAllCategories();
    public function getSingleCategory($id);
    public function addCategory(object $request);
    public function updateCategory(object $request,$id);
    public function deleteCategory($id);
    public function searchCategory($query);
    public function getItems($id);
}