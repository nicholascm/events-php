<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\User;
use App\EventUser;
use Stevenmaguire\Yelp\Client;
use App\Classes\SearchResults;

class EventController extends Controller
{
    public function __construct() {
      //$this->middleware('jwt.auth');
    }
     //provide list of all events that the user is attending

    public function index(Request $request, $user_id)
    {
        //get the current user
        $user = User::find(1)
          ->where('id', $user_id)
          ->first();

        //get the events for today that are associated with that user
        $user_events = $user->events()
          ->where('start_date', date('Y-m-d'))
          ->get();

        foreach ($user_events as $event) {
          $_event_users = EventUser::where('event_id', $event->id)
            ->get();

          $user_count = count($_event_users);

          $event->attending_count = $user_count;
        }

        return response()->json($user_events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $event = Event::firstOrCreate(['yelp_id' => $request->yelp_id, 'start_date' => date('Y-m-d')]);
      $event_user = EventUser::firstOrCreate(['event_id' => $event->id, 'user_id'=> $request->user_id]);
      return response()->json(compact('event', 'event_user'));
    }

    /**
     * Find or create a new event with an event attendee
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

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
        //add/remove new attending users here
        //get the resource by ID
        //find or create a new event user
        //take the action as determine in the request - updating the session_status
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
}
