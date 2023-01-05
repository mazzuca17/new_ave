<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class SchoolsController extends Controller
{
    public function create()
    {
        return view('superadmin.create');
    }

    public function store(Request $request)
    {
    }

    public function edit()
    {
    }

    public function update(Request $request, int $id)
    {
    }

    public function destroy(int $id)
    {
    }
}
