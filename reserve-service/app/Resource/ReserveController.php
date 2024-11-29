<?php

namespace App\Resource;

use App\Service\Interface\ReserverServiceInterface;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    private $reserveService;

    public function __construct(ReserverServiceInterface $reserveService)
    {
        $this->reserveService = $reserveService;
    }
}