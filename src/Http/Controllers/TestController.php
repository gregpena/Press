<?php

namespace Ubuntu\Press\Http\Controllers;

use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {
        return 'in controller';
    }
}