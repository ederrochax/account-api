<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EventService;

class EventController extends Controller
{
    private $eventService;
    
    public function __construct()
    {
        $this->eventService = new EventService;
    }
    
    public function event(Request $request)
    {
        try {
            $response = $this->eventService->directEvent($request);
            return response()->json($response, 201);
            
        } catch (\Throwable $e) {
            return response()->json(0, 404);
        }
    }

}
