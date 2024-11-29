<?php

namespace App\Service;

use App\Models\Reserve;
use App\Service\Interface\ReserverServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReserveService implements ReserverServiceInterface
{
    private $reserveRepository;

    function __construct(Reserve $reserveRepository)
    {
        $this->reserveRepository = $reserveRepository;
    }

    
}