<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $req)
    {
        return MenuService::getMenusJson($req);
    }
}
