<?php

namespace App\Utils;

use App\Services\EventService;
use App\Services\AccountService;

class Util
{
    private $accountService;
    private $eventService;
    
    function __construct()
    {
        $this->accountService = new AccountService;
        $this->eventService = new EventService;
    }
    
    public function resetDb()
    {
        $this->accountService->truncate();
        $this->eventService->truncate();
    }
}
