<?php

namespace App\Http\Controllers\CostumerPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('pages.home.index');
    }
}
