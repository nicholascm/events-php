<?php

namespace app\Classes;

use Stevenmaguire\Yelp\Client;


class BusinessSearch {


  public function __construct(String $yelp_id)
  {
    $this->yelp_id = $yelp_id;
  }

  public function getBusiness()
  {
    $client = new Client(array(
      'consumerKey' => env('YELP_CONSUMER_KEY'),
      'consumerSecret' => env('YELP_CONSUMER_SECRET'),
      'token' => env('YELP_TOKEN'),
      'tokenSecret' => env('YELP_TOKEN_SECRET'),
      'apiHost' => env('YELP_API_HOST')
    ));
    $client->setSearchLimit(20);

    $result = $client->getBusiness($this->yelp_id);
    return $result;
  }
}
