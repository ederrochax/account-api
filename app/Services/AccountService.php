<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountService
{
    public function createAccount(int $id, float $balance)
    {
        Account::create([
            'id' => $id, 
            'balance' => $balance,
        ]);            
        
        return $this->getAccountById($id);
    }
     
    public function balance(Request $request)
    {
        if($account = Account::find($request->get('account_id')))
            return $account->balance;
            
        return false;
    }
    
    public function updateBalance(int $id, float $newBalance)
    {
        Account::where('id', $id)
            ->update(['balance' => $newBalance]);
        
        return $this->getAccountById($id);
    }
    
    public function getAccountById(int $id)
    {
        return Account::find($id);
    }
    
    public function truncate()
    {
        Account::truncate();
    }
}
