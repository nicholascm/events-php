<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexJSONResponse()
    {
        $this->get('/api/events?search_term=burgers&location=Fort Walton Beach, FL')
             ->seeJsonStructure([
               '*' => ['id', 'created_at', 'updated_at', 'yelp_id', 'start_date']
             ]);
    }
}
