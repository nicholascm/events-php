<?php

namespace app\Classes;

use Stevenmaguire\Yelp\Client;
use App\Event;

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
  public function getYelpResults()
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

  //pull the ids from the returned yelp response for using to query database
  private function getIDsFromYelpResults()
  {
    $yelp_id_results = [];
    $yelp_results = $this->getYelpResults();
    $yelp_businesses = $yelp_results->businesses;
    foreach ($yelp_businesses as $event) {
        array_push($yelp_id_results, $event->id);
    }
    return $yelp_id_results;
  }

  //query the database using the set of IDs pulled from Yelp results
  public function getEventsWithAttendees()
  {
    $yelp_ids = $this->getIDsFromYelpResults();

    $events = [];

    foreach($yelp_ids as $id) {
      $event = Event::where('yelp_id', $id)
        ->where('start_date', date('Y-m-d'))
        ->get();
      if (count($event) > 0) {
        array_push($events, $event);
      }
    }
    return $events;
  }

  private function mergeEventsAndResults()
  {

    //TODO: Create this method so we can pad the database "events" results with information from the API for a single response to the client

  }



}
