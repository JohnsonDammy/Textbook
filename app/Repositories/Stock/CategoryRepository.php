<?php

namespace App\Repositories\Stock;

use App\Interfaces\Stock\CategoryRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\CollectionRequest;
use App\Models\StockCategory;
use App\Models\StockItem;
use Illuminate\Support\Facades\Request;

class CategoryRepository implements CategoryRepositoryInterface
{
    //getting all stock Items category
    public function getAllCategories()
    {
        $data =  StockCategory::orderby('name')->paginate(10);
        if (Request::input("all") ) {
            $data =  StockCategory::orderby('name')->get();
        }
        return $data;
    }


    //getting single stock item category
    public function getSingleCategory($id)
    {
        return StockCategory::find($id);
    }

    //getting category items list
    public function getItems($id)
    {
        if (StockCategory::find($id)) {
            return StockCategory::find($id)->getItem;
        }
        return [];
    }

    //add stock item category
    public function addCategory(object $request)
    {
        $cat = StockCategory::create([
            "name" => $request->name
        ]);
        return $cat;
    }

    //update stock item category
    public function updateCategory(object $request, $id)
    {
        $cat = StockCategory::find($id);
        $cat->name = $request->name;
        $cat->update();
        return $cat;
    }

    //delete stock item category
    public function deleteCategory($id)
    {
        $cat = StockItem::where('category_id', $id)->get();
        if (count($cat) > 0) {
            return null;
        }
        $data = StockCategory::find($id);
        $data->delete();
        return $data;
    }

    //search stock item category
    public function searchCategory($query)
    {
        $data = StockCategory::where("name", "like", "%" . $query . "%")->paginate(10)->withQueryString();
        if (Request::capture()->is('api/*')) {
            $data = StockCategory::where("name", "like", "%" . $query . "%")->get();
        }
        return $data;
    }
}
