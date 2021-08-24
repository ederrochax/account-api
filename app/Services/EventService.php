<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;

class EventService
{
    private $accountService;

    function __construct()
    {
        $this->accountService = new AccountService;
    }
    
    public function directEvent(Request $request)
    {
        $eventsTypes = ['deposit', 'withdraw', 'transfer'];
        $type = $request->type;
        
        if(in_array($type, $eventsTypes))
            return $this->$type($request);
        
        return abort(0, 404);
    }
    
    public function registerEvent(Request $request): void
    {
        Event::create([
            'type' => $request->type,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'amount' => $request->amount
        ]); 
    }    

    public function deposit(Request $request, bool $transfer = false)
    {
        $account = $this->accountService->getAccountById($request->destination);        
        if ($account){           
            $newBalance = ($account->balance + $request->amount);
            $update = $this->accountService->updateBalance($request->destination, $newBalance);
            
            if($update && !$transfer){
                $this->registerEvent($request);
                return ['destination' => $update];
            }
            return $update;
        }
        
        return $this->depositWithoutAccount($request, $transfer);
    }
    
    public function depositWithoutAccount(Request $request, bool $transfer = false)
    {
        $create = $this->accountService->createAccount($request->destination, $request->amount);
        if($create && !$transfer){
            $this->registerEvent($request);
            return ['destination' => $create];
        }
        
        return $create;
    }
    
    public function withdraw(Request $request, bool $transfer = false)
    {
        $account = $this->accountService->getAccountById($request->origin);
        if($account){
            $newBalance = ($account->balance - $request->amount);
            $update = $this->accountService->updateBalance($request->origin, $newBalance);
            
            if($update && !$transfer){
                $this->registerEvent($request);
                return ['origin' => $update];
            }
            
            return $update;
        }
        
        return abort(0, 404);
    }
    
    public function transfer(Request $request)
    {
        $transfer = [
            'origin' => $this->withdraw($request, true),
            'destination' => $this->deposit($request, true)   
        ];
        
        $this->registerEvent($request);
        
        return $transfer;
    }
    
    public function truncate()
    {
        Event::truncate();
    }        
}
