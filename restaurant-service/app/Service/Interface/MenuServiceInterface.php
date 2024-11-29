<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface MenuServiceInterface 
{
    public function register(Request $request);

    public function delete(Request $request, $id);

    public function deleteItem(Request $request, $id);

    public function addItem(Request $request); 
}