<?php

namespace app\Classes;

use Stevenmaguire\Yelp\Client;
use App\Event;
use App\EventUser;

/* Class will be utilized to hide functionality needed to merge Yelp search results with results from the database.

Public API will accept a string search term and a string location, return the search results loaded with the attendees from the database

*/

class SearchResults {


  public function __construct(String $search_term, String $location)
  {
    $this->search_term = $search_term;
    $this->location = $location;
  }

  //wrapper for API call for the object
  private function getYelpResults()
  {
    $client = new Client(array(
      'consumerKey' => env('YELP_CONSUMER_KEY'),
      'consumerSecret' => env('YELP_CONSUMER_SECRET'),
      'token' => env('YELP_TOKEN'),
      'tokenSecret' => env('YELP_TOKEN_SECRET'),
      'apiHost' => env('YELP_API_HOST')
    ));
    $client->setSearchLimit(20);

    $results = $client->search(array('term' => $this->search_term, 'location' => $this->location));
    return $results;
  }

  //Just get the businesses from the yelp response

  private function getBusinesses()
  {
    $yelp_id_results = [];
    $yelp_results = $this->getYelpResults();
    $yelp_businesses = $yelp_results->businesses;
    return $yelp_businesses;
  }

  //query for the attendees of a search result if an event already exists
  public function getSearchResultsWithAttendees()
  {
    $businesses = $this->getBusinesses();
    foreach ($businesses as $location) {
      $event = Event::where('yelp_id', $location->id)
        ->where('start_date', date('Y-m-d'))
        ->first();

      if ($event) {
        $location->attendees = EventUser::where('event_id', $event->id)
          ->join('users', 'event_user.user_id','=','users.id')
          ->get(['name','email']);
      } else {
        $location->attendees = [];
      }

    }
    return $businesses;
  }

}
