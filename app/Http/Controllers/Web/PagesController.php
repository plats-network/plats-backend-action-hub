<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct() {}

    public function solution(Request $request)
    {
        return view('web.solution');
    }

    public function template(Request $request)
    {
        return view('web.template');
    }

    public function pricing(Request $request)
    {
        return view('web.pricing');
    }

    public function resource(Request $request)
    {
        return view('web.resource');
    }

    public function contact(Request $request)
    {
        return view('web.contact');
    }
}
