<?php

namespace App\Http\Controllers\Admin\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchByDateRangeRequest;
use App\Http\Requests\Search\SearchByRefNumberRequest;
use App\Interfaces\SearchRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    protected $connection = 'itrfurns'; // Use the 'itrfurn' database connection

    private SearchRepositoryInterface $searchRepository;


    function __construct(SearchRepositoryInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function index(Request $request)
    {
        $data = $this->searchRepository->searchRequestItems($request);
        return view('furniture.search.search', ['data' => $data]);
    }

    public function searchByReference(SearchByRefNumberRequest $request)
    {
        if ($request->validated()) {
            // dd($request);
            return $this->search($request);
        }
    }

    public function searchByDateRange(SearchByDateRangeRequest $request)
    {
        if ($request->validated()) {
            // dd($request);
            return $this->search($request);
        }
    }

    public function search(Request $request)
    {
        $data = $this->searchRepository->searchRequestItems($request);
        if (!empty($data['records'])) {
            return view('furniture.search.search', ['data' => $data]);
        }
        return redirect('/search/home')->with('searcherror', 'Your search did not match any records.')->withInput();
    }
}
