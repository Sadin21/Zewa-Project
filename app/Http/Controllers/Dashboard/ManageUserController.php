<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ManageUserController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard.manage-user.index');
    }
}
