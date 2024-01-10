<?php

namespace App\Http\Controllers\Api\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Stock\Category\StoreStockCategoryRequest;
use App\Http\Requests\Stock\Category\UpdateStockCategoryRequest;
use App\Interfaces\Stock\CategoryRepositoryInterface;
use App\Models\StockCategory;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class StockCategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    function  __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('api_permission:category-list|category-create|category-edit|category-delete', ['only' => ['store']]);
        $this->middleware('api_permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('api_permission:category-edit', ['only' => ['show', 'update']]);
        $this->middleware('api_permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->categoryRepository->getAllCategories();
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
        return response()->json(["message" => $data ? "Item category list." : "No Data Found", "data" => $list], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockCategoryRequest $request)
    {
        try {
            $data = $this->categoryRepository->addCategory($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Item category added !", "data" => $this->list($data)], Response::HTTP_CREATED);
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
            $data = $this->categoryRepository->getSingleCategory($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "Item category details." : "No Data Found", "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = $this->categoryRepository->getItems($id);
            $list = [];
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $list[] = [
                        "id" => $item->id,
                        "name" => $item->name,
                        "category_id" => $item->category_id,
                        "category_name" => $item->getCategory->name
                    ];
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => count($data) > 0 ? "Item category items details." : "No Data Found", "data" => $list], count($data) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockCategoryRequest $request, $id)
    {
        $cat = StockCategory::find($id);
        if (!$cat) {
            return response()->json(["message" => "Item cetegory not found with id : $id", "data" => ""], Response::HTTP_NOT_FOUND);
        }
        try {
            $data = $this->categoryRepository->updateCategory($request, $id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "Item category updated !", "data" => $this->list($data)], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = StockCategory::find($id);
        if (!$cat) {
            return response()->json(["message" =>  "No Item category found to delete", "data" => ""], Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $this->categoryRepository->deleteCategory($id);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => $data ? "Item category has been deleted" : 'Unable to delete Item category . because catgory having Item description', "data" => $data ? $this->list($data) : ''], $data ? Response::HTTP_OK : Response::HTTP_FORBIDDEN);
    }

    public function stockCategorySearch(SearchRequest $request)
    {
        try {
            $data = $this->categoryRepository->searchCategory($request->input('query'));
            $list = [];
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $list[] = $this->list($item);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => count($data) > 0 ? "Item category search list." : "Your search did not match any records", "data" => $list], count($data) > 0 ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    protected function list(object $category)
    {
        return [
            "id" => $category->id,
            "name" => $category->name
        ];
    }
}
