<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Stock\Item\StoreStockItemRequest;
use App\Http\Requests\Stock\Item\UpdateStockItemRequest;
use App\Interfaces\Stock\ItemRepositoryInterface;
use App\Models\StockItem;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class StockItemController extends Controller
{
    private ItemRepositoryInterface $itemRepository;

    function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->middleware('api_permission:item-list|item-create|item-edit|item-delete', ['only' => ['store']]);
        $this->middleware('api_permission:item-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:item-edit', ['only' => ['edit', 'show', 'update']]);
        $this->middleware('api_permission:item-delete', ['only' => ['destroy']]);
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
            $list = [];
            if (count($data) > 0) {
                if (!Request::input('all')) {
                    $list = [
                        "next_page" => $data->nextPageUrl(),
                        "previous_page" => $data->previousPageUrl(),
                        "total_page" => $data->lastPage(),
                        "total_records" => $data->total(),
                        "current_records" => $data->count()
                    ];
                }
                foreach ($data as $key => $item) {
                    $list["records"][$key] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "Item Description list." : "NO Data Found", "data" => $list], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockItemRequest $request)
    {
        try {
            $data = $this->itemRepository->addItem($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Item Description added !", "data" => $this->list($data)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->itemRepository->getSingleItem($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "Item Description  details." : "No Data Found", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
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
        $stock = StockItem::find($id);
        if (!$stock) {
            return response()->json(["message" => "Item Description not found with id : $id", "data" => ""], Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $this->itemRepository->updateItem($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Item Description has been updated !", "data" => $this->list($data)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = StockItem::find($id);
        if (!$stock) {
            return response()->json(["message" => "Item Description not found with id : $id", "data" => ""], Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $this->itemRepository->deleteItem($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "Item Description has been deleted" : "Item Description can not be deleted!", "data" => $data ? $this->list($data) : ''], $data ?  Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    public function stockItemSearch(SearchRequest $request)
    {

        try {
            $data = $this->itemRepository->searchItem($request->input('query'));
            $list = [];
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $list[] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => count($data) > 0 ? "Item Description search list." : "Your search did not match any records", "data" => $list], count($data) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    protected function list(object $item)
    {
        return [
            "id" => $item->id,
            "name" => $item->name,
            "category_id" => $item->category_id,
            "category_name" => $item->getCategory->name
        ];
    }
}
