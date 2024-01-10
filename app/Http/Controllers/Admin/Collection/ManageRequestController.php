<?php

namespace App\Http\Controllers\Admin\Collection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\FurnitureRequest\CollectionRequestRepositoryInterface;
use App\Http\Requests\CollectionRequestSearch;
use App\Http\Requests\FurnitureCollection\UpdateFurnitureCollection;
use App\Interfaces\SearchRepositoryInterface;
use App\Models\CollectionRequest;
use Symfony\Component\HttpFoundation\Response;

class ManageRequestController extends Controller
{
    private CollectionRequestRepositoryInterface $collectionRequestRepository;
    private SearchRepositoryInterface $searchRepository;

    function __construct(CollectionRequestRepositoryInterface $collectionRequestRepository, SearchRepositoryInterface $searchRepository)
    {
        $this->collectionRequestRepository = $collectionRequestRepository;
        $this->searchRepository = $searchRepository;
        $this->middleware('permission:manage-request-list|manage-request-create|manage-request-edit|manage-request-delete', ['only' => ['index', 'store', 'search']]);
        $this->middleware('permission:manage-request-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manage-request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manage-request-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  $this->collectionRequestRepository->getAllManageRequest();
        return view('furniture.managerequest.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = CollectionRequest::where('id', '=', $id)->first();
        if (!$data) {
            return redirect()->back()->with("error", "Collection request not found");
        }
        $items = [];
        foreach ($data->getBrokenItems as $item) {
            $items[] = [
                "id" => $item->id,
                "category_id" => $item->category_id,
                "category_name" => $item->getCategoryDetails->name,
                "item_id" => $item->item_id,
                "item_name" => $item->getItemDetails->name,
                "count" => $item->count,
                "item_full_count" => $item->item_full_count
            ];
        }
        return view('furniture.managerequest.edit', ['data' => $data, 'items' => $items]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFurnitureCollection $request, $id)
    {
        if ($request->validated()) {
            try {
                $data = $this->collectionRequestRepository->EditCollectionRequest($request, $id);
            } catch (\Throwable $th) {
                throw $th;
                // return back()->with('error', 'Error - Adding new Request failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return response($data, Response::HTTP_CREATED);
                // return redirect()->route('furniture-collection-request.index')->with('success', 'Your Furniture Collection Request has been submitted successfully!');
            }
            // dd("failded");
            // return back()->with('error', 'Adding new school failed.')->withInput();
            return response($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        dd("validation error");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->collectionRequestRepository->deleteCollectionRequest($id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error - Deleting furniture collection request failed. ' . $th->getMessage());
        }
        if ($data) {
            return back()->with('success', 'Furniture collection request deleted successfully!');
        }
        return back()->with('error', 'Deleting furniture collection request failed.');
    }

    public function search(CollectionRequestSearch $request)
    {
        if ($request->validated()) {
            // dd($request);
            $data = $this->searchRepository->searchRequest($request);
            if ($data == null) {
                return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
            } elseif (count($data) > 0) {
                return view('furniture.managerequest.list', ['data' => $data]);
            }
            return redirect('manage-requests')->with('searcherror', 'Your search did not match any records.')->withInput();
        }
    }
}
