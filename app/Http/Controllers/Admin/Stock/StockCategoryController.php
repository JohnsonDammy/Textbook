<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Interfaces\Stock\CategoryRepositoryInterface;
use App\Http\Requests\Stock\Category\StoreStockCategoryRequest;
use App\Http\Requests\Stock\Category\UpdateStockCategoryRequest;
use App\Models\StockCategory;
use App\Models\StockItem;

class StockCategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;
    function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
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
        } catch (\Throwable $th) {
            throw $th;
        }
        return view('furniture.maintenance.stock.categories.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('furniture.maintenance.stock.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockCategoryRequest $request)
    {
        if ($request->validated()) {
            try {
                $data = $this->categoryRepository->addCategory($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Adding new Item category failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('stockcategories.index')
                    ->with('success', "Item category added successfully!");
            }
            return back()->with('error', 'Adding new Item category failed.')->withInput();
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
        $category = StockCategory::find($id);
        return view('furniture.maintenance.stock.categories.edit', compact('category'));
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
        if ($request->validated()) {
            try {
                $data = $this->categoryRepository->updateCategory($request, $id);
            } catch (\Throwable $th) {
                return back()->with('error', 'Error - Updating Item category failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect()->route('stockcategories.index')
                    ->with('success', 'Item category updated successfully!');
            }
            return back()->with('error', 'Updating Item category failed.')->withInput();
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
        $category = StockCategory::find($id);
        $items = StockItem::where('category_id', $category->id)->get();
        if (count($items) > 0) {
            return back()->with('alert', 'Item category cannot be deleted as item Description are added to it.');
        }
        try {
            $data = $this->categoryRepository->deleteCategory($id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error - Deleting Item category failed. ' . $th->getMessage());
        }
        if ($data) {
            return back()->with('success', 'Item category deleted successfully!');
        }
        return back()->with('error', 'Deleting Item category failed.');
    }

    public function search(SearchRequest $request)
    {
        if ($request->validated()) {
            $data = $this->categoryRepository->searchCategory($request->input('query'));
            if (count($data) > 0) {
                return view('furniture.maintenance.stock.categories.list', ['data' => $data]);
            }
            return redirect()->route('stockcategories.index')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
}
