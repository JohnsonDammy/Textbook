<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Stock\Item\StoreStockItemRequest;
use App\Http\Requests\Stock\Item\UpdateStockItemRequest;
use App\Interfaces\Stock\ItemRepositoryInterface;
use App\Models\StockItem;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    private ItemRepositoryInterface $itemRepository;
    function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;

        $this->middleware('permission:item-list|item-create|item-edit|item-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:item-delete', ['only' => ['destroy']]);
        $this->middleware('permission:category-list|item-list', ['only' => ['stockmaintenance']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->itemRepository->getAllItems();
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.stock.items.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.stock.items.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockItemRequest $request)
    {
        if ($request->validated()) {
            try {
                $data = $this->itemRepository->addItem($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new Item Description failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('stockitems.index')
                    ->with('success', "Item Description added successfully!");
            }
            return back()->with('error', 'Adding new Item Description failed.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = StockItem::find($id);
        return view('furniture.maintenance.stock.items.edit',['item' => $item]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockItemRequest $request, $id)
    {
        if ($request->validated()) {
            try {
                $data = $this->itemRepository->updateItem($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating Item Description failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('stockitems.index')
                    ->with('success', "Item Description updated successfully!");
            }
            return back()->with('error', 'Updating Item Description failed.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = StockItem::find($id);
        if(!$item){
            return back()->with('error', 'Item Description not found');
        }
        try {
            $data = $this->itemRepository->deleteItem($id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error - Deleting Item Description failed. ' . $th->getMessage());
        }
        if ($data) {
            return redirect()->route('stockitems.index')->with('success', 'Item Description deleted successfully!');
        }
        return back()->with('error', 'Deleting Item Description failed.');
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->itemRepository->searchItem($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.stock.items.list', ['data' => $data]);
            }
            return redirect()->route('stockitems.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }

    public function stockmaintenance()
    {
        return view('furniture.maintenance.stock.stockmaintenance');
    }

    public function getitems(Request $request)
    {
        $cat_id = $request->catid;
        $items = StockItem::where('category_id', '=', $cat_id)->get();
        // dd($items);
        return json_encode($items);
    }
}
