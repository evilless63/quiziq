<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;

class AdminController extends Controller
{
    public function Index() {
        return View('/admin/index');
    }
}
