<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Path;
use App\Models\Statistice;

class HomeController extends Controller
{
    public function __construct()
    {
        app()->setLocale('ar');
    }

    public function index()
    {
        $paths = Path::all();
        $statistices = Statistice::paginate(4);
        return view('frontend.index', compact('paths', 'statistices'));
    }

    public function path($id)
    {
        $path = Path::where('id', $id)->first();
        return view('frontend.paths', compact('id', 'path'));
    }

    public function about()
    {
        $statistices = Statistice::paginate();
        return view('frontend.about', compact('statistices'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
