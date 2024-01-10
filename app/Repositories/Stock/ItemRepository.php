<?php

namespace App\Repositories\Stock;

use App\Interfaces\Stock\ItemRepositoryInterface;
use App\Models\BrokenItem;
use App\Models\StockItem;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ItemRepository implements ItemRepositoryInterface
{
    //getting all stock Items
    public function getAllItems()
    {
        $data =  StockItem::orderby('name')->paginate(10);
        if (Request::input('all')) {
            $data =  StockItem::orderby('name')->get();
        }
        return $data;
    }

    //getting single stock item
    public function getSingleItem($id)
    {
        return StockItem::find($id);
    }

    //add stock item
    public function addItem($request)
    {
        $item = StockItem::create([
            "name" => $request->name,
            "category_id" => $request->category_id
        ]);
        return $item;
    }

    //update stock item
    public function updateItem($request, $id)
    {
        $item = StockItem::find($id);
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->update();
        return $item;
    }

    //delete stock item
    public function deleteItem($id)
    {
        $cat = BrokenItem::where('category_id', $id)->get();
        if (count($cat) > 0) {
            return null;
        }
        $data = StockItem::find($id);
        $data->delete();
        return $data;
    }

    //search stock item
    public function searchItem($query)
    {
        $data = StockItem::where("name", "like", "%" . $query . "%")->paginate(10)->withQueryString();
        if (Request::capture()->is('api/*')) {
            $data = StockItem::where("name", "like", "%" . $query . "%")->get();
        }
        return $data;
    }
}
