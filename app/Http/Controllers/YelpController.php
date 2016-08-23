<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Classes\SearchResults;


class YelpController extends Controller
{

    public function __construct()
    {

    }
    public function search(Request $request)
    {
      $yelp = new SearchResults($request->search_term, $request->location);
      $results = $yelp->getSearchResultsWithAttendees();
      return response()->json($results);
    }
}
