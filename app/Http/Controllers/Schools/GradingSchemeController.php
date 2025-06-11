<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GradingSchemeController extends Controller
{
    public function index()
    {
        return view('school.grading_schemes.index');
    }
    public function show()
    {
        Log::debug('sdsd');
    }
    public function create() {}
    public function store() {}
    public function update() {}
    public function destroy() {}
}
