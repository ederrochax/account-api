<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;
    
    public function __construct()
    {
        $this->accountService = new AccountService;
    }

    public function balance(Request $request)
    {
        if($balance = $this->accountService->balance($request))
            return response($balance);
            
        return response()->json(0, 404);
    }
        
}
