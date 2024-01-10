<?php

namespace App\Http\Controllers\Admin\Collection;

use App\Http\Controllers\Controller;
use App\Http\Requests\FurnitureCollection\StoreFurnitureCollection;
use App\Http\Requests\CollectionRequestSearch;
use App\Interfaces\FurnitureRequest\CollectionRequestRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CollectionRequestController extends Controller
{
    private CollectionRequestRepositoryInterface $collectionRequestRepository;
    private SearchRepositoryInterface $searchRepository;

    function __construct(CollectionRequestRepositoryInterface $collectionRequestRepository, SearchRepositoryInterface $searchRepository)
    {
        $this->collectionRequestRepository = $collectionRequestRepository;
        $this->searchRepository = $searchRepository;
        $this->middleware('permission:collection-request-list|collection-request-create|collection-request-edit|collection-request-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:collection-request-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:collection-request-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:collection-request-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  $this->collectionRequestRepository->getAllRequest();
        return view('furniture.collectionrequest.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->collectionRequestRepository->checkActiveRequest();
        // dd($data);
        return view('furniture.collectionrequest.add', ['school' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFurnitureCollection $request)
    {

        if ($request->validated()) {
            try {
                $data = $this->collectionRequestRepository->AddCollectionRequest($request);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(CollectionRequestSearch $request)
    {
        
            // dd($request);
            $data = $this->searchRepository->searchRequest($request);
            if ($data == null) {
                return back()->with('error', 'At least one search criteria must be entered to conduct a search.');
            } elseif (count($data) > 0) {
                return view('furniture.collectionrequest.list', ['data' => $data]);
            }
            return redirect()->route('furniture-replacement.index')->with('searcherror', 'Your searches did not match any records.')->withInput();
        
    }

}
