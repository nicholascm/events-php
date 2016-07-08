<?php

namespace app\Classes;

/* Class will be utilized to hide functionality needed to merge Yelp search results with results from the database.

Public API will accept a string search term and a string location, return the search results loaded with the attendees from the database

*/

class SearchResults {

/*
  protected $keys = array(
    'consumerKey' => env('YELP_CONSUMER_KEY'),
    'consumerSecret' => env('YELP_CONSUMER_SECRET'),
    'token' => env('YELP_TOKEN'),
    'tokenSecret' => env('YELP_TOKEN_SECRET'),
    'apiHost' => env('YELP_API_HOST')
  );
*/
  public function __construct(String $search_term, String $location)
  {
    $this->$search_term = $search_term;
    $this->$location = $location;
  }

  public function getEventsWithAttendees()
  {

  }

  private function getOnlyRelevantProperties() {

  }

  private function mergeEventsAndResults()
  {

  }

  private function getSearchResults()
  {

  }

}
